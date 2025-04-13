//PRUDUCAO NOVA

import express from 'express';
import https from 'https';
import { Server } from 'socket.io';
import cors from 'cors';
import axios from 'axios';
import * as fs from 'fs'; // <- CORRETO com ESM

const app = express();

// // Caminhos para os certificados SSL
const options = {
    cert: fs.readFileSync('/etc/letsencrypt/live/proconline.com.br/fullchain.pem'),
    key: fs.readFileSync('/etc/letsencrypt/live/proconline.com.br/privkey.pem')
};

const server = https.createServer(options, app);

const io = new Server(server, {
  cors: {
    origin: "https://proconline.com.br",
    methods: ["GET", "POST"],
    credentials: true
  }
});

app.use(cors());
app.use(express.json());

let onlineUsers = {}; // Armazena usuários online e offline

async function buildUserListFor(userId) {
    const currentUser = onlineUsers[userId];
    if (!currentUser) return [];

    const users = await Promise.all(
        Object.values(onlineUsers)
            .filter(u => u.id !== userId)
            .map(async (usr) => {
                try {
                    const response = await axios.get(`http://localhost:8990/api/chat/last-message`, {
                        params: {
                            user_id: userId,
                            recipient_id: usr.id
                        },
                        headers: {
                            Authorization: `Bearer ${currentUser.token}`
                        }
                    });

                    return {
                        ...usr,
                        content: response.data.message || 'Sem mensagens ainda',
                        timestamp: response.data.timestamp || null,
                        sender_name: response.data.sender_name || 'Desconhecido',
                        unread_count: response.data.unread_count || 0
                    };
                } catch (err) {
                    console.error(`Erro ao buscar última mensagem de ${usr.name}:`, err.message);
                    return {
                        ...usr,
                        content: 'Sem mensagens ainda',
                        timestamp: null,
                        sender_name: 'Desconhecido',
                        unread_count: 0
                    };
                }
            })
    );

    return users;
}


io.on('connection', (socket) => {
    console.log('Usuário conectado:', socket.id);

    // Evento para registrar usuários online
    socket.on('user connected', (user) => {
        if (user && user.id) {
            onlineUsers[user.id] = {
                id: user.id,
                name: user.name,
                image: user.image,
                socketId: socket.id,
                status: 'Online',
                token: user.token
            };

            // Enviar a lista de usuários online para TODOS os usuários, excluindo eles mesmos
            Object.values(onlineUsers).forEach(async (u) => {
                if (u.socketId) {
                    const usersWithLastMessages = await buildUserListFor(u.id);
                    io.to(u.socketId).emit('update online users', usersWithLastMessages);
                }
            });
            
        }
    });

    // Evento para mensagens do chat
    socket.on('chat message', async (data) => {
        const { content, sender_id } = data;
        console.log('Dados recebidos no evento chat message:', data);
        try {
            //const sentAt = new Date().toISOString();
            const user = onlineUsers[sender_id];

            if (!user) {
                console.error('Usuário não encontrado na lista de onlineUsers:', sender_id);
                return;
            }

            // Enviar mensagem para API Laravel
            const response = await axios.post('http://localhost:8990/api/chat/send-message', {
                chat_id: data.chat_id,
                message: content,
                sender_id: data.sender_id, // <-- adicionado aqui
            }, {
                headers: {
                    Authorization: `Bearer ${data.token}` // se estiver usando autenticação via token
                }
            });
            

            console.log('Emitindo a mensagem:', response.data);

            // Emitir mensagem com dados completos
            io.emit('chat message', {
                content: response.data.message.content,
                sender_id: response.data.message.sender_id,
                chat_id: response.data.message.chat_id,
                sent_at: response.data.message.created_at,
                user: response.data.message.sender
            });

            Object.values(onlineUsers).forEach(async (u) => {
                if (u.socketId) {
                    const usersWithLastMessages = await buildUserListFor(u.id);
                    io.to(u.socketId).emit('update online users', usersWithLastMessages);
                }
            });
            

        } catch (error) {
            console.error('Erro ao salvar mensagem:', error.message);
            console.error('Detalhes do erro:', error.response ? error.response.data : error.message);
        }
    });

    // Evento para desconectar usuários
    socket.on('disconnect', () => {
        let disconnectedUserId = null;

        for (let userId in onlineUsers) {
            if (onlineUsers[userId].socketId === socket.id) {
                onlineUsers[userId].status = 'Offline'; // Atualiza status para offline
                onlineUsers[userId].socketId = null; // Remove socketId
                disconnectedUserId = userId;
                break;
            }
        }

        if (disconnectedUserId) {
            // Enviar a lista de usuários online para TODOS os usuários, excluindo eles mesmos
            Object.values(onlineUsers).forEach(async (u) => {
                if (u.socketId) {
                    const usersWithLastMessages = await buildUserListFor(u.id);
                    io.to(u.socketId).emit('update online users', usersWithLastMessages);
                }
            });
            
        }

        console.log('Usuário desconectado:', socket.id);
    });
});

app.post('/message', (req, res) => {
    const msg = req.body.message;

    console.log("Mensagem recebida via HTTP:", msg);

    // Emite para todos os clientes conectados
    io.emit('chat message', msg);

    res.status(200).send('OK');
});

server.listen(6002, '0.0.0.0', () => {
    console.log('Servidor rodando na porta 6002');
});

//DESENVOLVIMENTO NOVO

// import express from 'express';
// import http from 'http';
// import { Server } from 'socket.io';
// import cors from 'cors';
// import axios from 'axios';

// const app = express();
// const server = http.createServer(app);
// const io = new Server(server, {
//     cors: {
//         origin: "*",
//         methods: ["GET", "POST"]
//     }
// });

// app.use(cors());
// app.use(express.json());

// let onlineUsers = {}; // Armazena usuários online e offline

// async function buildUserListFor(userId) {
//     const currentUser = onlineUsers[userId];
//     if (!currentUser) return [];

//     const users = await Promise.all(
//         Object.values(onlineUsers)
//             .filter(u => u.id !== userId)
//             .map(async (usr) => {
//                 try {
//                     const response = await axios.get(`http://localhost:8990/api/chat/last-message`, {
//                         params: {
//                             user_id: userId,
//                             recipient_id: usr.id
//                         },
//                         headers: {
//                             Authorization: `Bearer ${currentUser.token}`
//                         }
//                     });

//                     return {
//                         ...usr,
//                         content: response.data.message || 'Sem mensagens ainda',
//                         timestamp: response.data.timestamp || null,
//                         sender_name: response.data.sender_name || 'Desconhecido',
//                         unread_count: response.data.unread_count || 0
//                     };
//                 } catch (err) {
//                     console.error(`Erro ao buscar última mensagem de ${usr.name}:`, err.message);
//                     return {
//                         ...usr,
//                         content: 'Sem mensagens ainda',
//                         timestamp: null,
//                         sender_name: 'Desconhecido',
//                         unread_count: 0
//                     };
//                 }
//             })
//     );

//     return users;
// }


// io.on('connection', (socket) => {
//     console.log('Usuário conectado:', socket.id);

//     // Evento para registrar usuários online
//     socket.on('user connected', (user) => {
//         if (user && user.id) {
//             onlineUsers[user.id] = {
//                 id: user.id,
//                 name: user.name,
//                 image: user.image,
//                 socketId: socket.id,
//                 status: 'Online',
//                 token: user.token
//             };

//             // Enviar a lista de usuários online para TODOS os usuários, excluindo eles mesmos
//             Object.values(onlineUsers).forEach(async (u) => {
//                 if (u.socketId) {
//                     const usersWithLastMessages = await buildUserListFor(u.id);
//                     io.to(u.socketId).emit('update online users', usersWithLastMessages);
//                 }
//             });
            
//         }
//     });

//     // Evento para mensagens do chat
//     socket.on('chat message', async (data) => {
//         const { content, sender_id } = data;
//         console.log('Dados recebidos no evento chat message:', data);
//         try {
//             //const sentAt = new Date().toISOString();
//             const user = onlineUsers[sender_id];

//             if (!user) {
//                 console.error('Usuário não encontrado na lista de onlineUsers:', sender_id);
//                 return;
//             }

//             // Enviar mensagem para API Laravel
//             const response = await axios.post('http://localhost:8990/api/chat/send-message', {
//                 chat_id: data.chat_id,
//                 message: content,
//                 sender_id: data.sender_id, // <-- adicionado aqui
//             }, {
//                 headers: {
//                     Authorization: `Bearer ${data.token}` // se estiver usando autenticação via token
//                 }
//             });
            

//             console.log('Emitindo a mensagem:', response.data);

//             // Emitir mensagem com dados completos
//             io.emit('chat message', {
//                 content: response.data.message.content,
//                 sender_id: response.data.message.sender_id,
//                 chat_id: response.data.message.chat_id,
//                 sent_at: response.data.message.created_at,
//                 user: response.data.message.sender
//             });

//             Object.values(onlineUsers).forEach(async (u) => {
//                 if (u.socketId) {
//                     const usersWithLastMessages = await buildUserListFor(u.id);
//                     io.to(u.socketId).emit('update online users', usersWithLastMessages);
//                 }
//             });
            

//         } catch (error) {
//             console.error('Erro ao salvar mensagem:', error.message);
//             console.error('Detalhes do erro:', error.response ? error.response.data : error.message);
//         }
//     });

//     // Evento para desconectar usuários
//     socket.on('disconnect', () => {
//         let disconnectedUserId = null;

//         for (let userId in onlineUsers) {
//             if (onlineUsers[userId].socketId === socket.id) {
//                 onlineUsers[userId].status = 'Offline'; // Atualiza status para offline
//                 onlineUsers[userId].socketId = null; // Remove socketId
//                 disconnectedUserId = userId;
//                 break;
//             }
//         }

//         if (disconnectedUserId) {
//             // Enviar a lista de usuários online para TODOS os usuários, excluindo eles mesmos
//             Object.values(onlineUsers).forEach(async (u) => {
//                 if (u.socketId) {
//                     const usersWithLastMessages = await buildUserListFor(u.id);
//                     io.to(u.socketId).emit('update online users', usersWithLastMessages);
//                 }
//             });
            
//         }

//         console.log('Usuário desconectado:', socket.id);
//     });
// });

// app.post('/message', (req, res) => {
//     const msg = req.body.message;

//     console.log("Mensagem recebida via HTTP:", msg);

//     // Emite para todos os clientes conectados
//     io.emit('chat message', msg);

//     res.status(200).send('OK');
// });

// server.listen(6002, '0.0.0.0', () => {
//     console.log('Servidor rodando na porta 6002');
// });
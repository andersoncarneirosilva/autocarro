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

// io.on('connection', (socket) => {
//     console.log('Usuário conectado:', socket.id);

//     // Evento para registrar usuários online
//     socket.on('user connected', (user) => {
//         if (user && user.id) {
//             onlineUsers[user.id] = {
//                 id: user.id,
//                 name: user.name,
//                 socketId: socket.id,
//                 status: 'online'
//             };

//             // Enviar a lista de usuários online para TODOS os usuários, excluindo eles mesmos
//             Object.values(onlineUsers).forEach(u => {
//                 if (u.socketId) {
//                     io.to(u.socketId).emit('update online users', 
//                         Object.values(onlineUsers).filter(usr => usr.id !== u.id)
//                     );
//                 }
//             });
//         }
//     });

//     // Evento para mensagens do chat
//     socket.on('chat message', async (data) => {
//         const { content, sender_id } = data;

//         try {
//             const sentAt = new Date().toISOString();
//             const user = onlineUsers[sender_id];

//             if (!user) {
//                 console.error('Usuário não encontrado na lista de onlineUsers:', sender_id);
//                 return;
//             }

//             // Enviar mensagem para API Laravel
//             const response = await axios.post('http://localhost:8990/api/messages', {
            
//                 content,
//                 sender_id,
//                 sent_at: sentAt,
//             });

//             console.log('Mensagem salva:', response.data);

//             // Emitir mensagem com dados completos
//             io.emit('chat message', {
//                 content: response.data.content,
//                 sender_id: response.data.sender_id,
//                 sent_at: sentAt,
//                 user: {
//                     id: user.id,
//                     name: user.name
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
//                 onlineUsers[userId].status = 'offline'; // Atualiza status para offline
//                 onlineUsers[userId].socketId = null; // Remove socketId
//                 disconnectedUserId = userId;
//                 break;
//             }
//         }

//         if (disconnectedUserId) {
//             // Enviar a lista de usuários online para TODOS os usuários, excluindo eles mesmos
//             Object.values(onlineUsers).forEach(u => {
//                 if (u.socketId) {
//                     io.to(u.socketId).emit('update online users', 
//                         Object.values(onlineUsers).filter(usr => usr.id !== u.id)
//                     );
//                 }
//             });
//         }

//         console.log('Usuário desconectado:', socket.id);
//     });
// });

// server.listen(6002, '0.0.0.0', () => {
//     console.log('Servidor rodando na porta 6002');
// });











//PRODUCAO
// import express from 'express';
// import https from 'https';
// import fs from 'fs';
// import { Server } from 'socket.io';
// import cors from 'cors';
// import axios from 'axios';

// const app = express();

// // 🔐 Configuração do HTTPS com Let's Encrypt
// const options = {
//     key: fs.readFileSync('/etc/letsencrypt/live/proconline.com.br/privkey.pem'),
//     cert: fs.readFileSync('/etc/letsencrypt/live/proconline.com.br/fullchain.pem')
// };

// const server = https.createServer(options, app);
// const io = new Server(server, {
//     cors: {
//         origin: "https://proconline.com.br",  // ✅ Apenas conexões do frontend em produção
//         methods: ["GET", "POST"]
//     }
// });

// app.use(cors({
//     origin: "https://proconline.com.br"  // ✅ Permite apenas este domínio
// }));
// app.use(express.json());

// let onlineUsers = {}; // 🔄 Armazena usuários online e offline

// io.on('connection', (socket) => {
//     console.log('Usuário conectado:', socket.id);

//     // 🔵 Registrar usuários online
//     socket.on('user connected', (user) => {
//         if (user && user.id) {
//             onlineUsers[user.id] = {
//                 id: user.id,
//                 name: user.name,
//                 socketId: socket.id,
//                 status: 'online'
//             };

//             // Atualizar a lista de usuários online
//             io.emit('update online users', Object.values(onlineUsers));
//         }
//     });

//     // 💬 Receber mensagens do chat
//     socket.on('chat message', async (data) => {
//         const { content, sender_id } = data;

//         try {
//             const sentAt = new Date().toISOString();
//             const user = onlineUsers[sender_id];

//             if (!user) {
//                 console.error('Usuário não encontrado:', sender_id);
//                 return;
//             }

//             // 🔄 Salvar mensagem no Laravel (API em produção)
//             const response = await axios.post('https://proconline.com.br/api/messages', {
//                 content,
//                 sender_id,
//                 sent_at: sentAt,
//             });

//             console.log('Mensagem salva:', response.data);

//             // 📨 Enviar mensagem para todos os usuários
//             io.emit('chat message', {
//                 content: response.data.content,
//                 sender_id: response.data.sender_id,
//                 sent_at: sentAt,
//                 user: {
//                     id: user.id,
//                     name: user.name
//                 }
//             });
//         } catch (error) {
//             console.error('Erro ao salvar mensagem:', error.message);
//         }
//     });

//     // 🔴 Desconectar usuário
//     socket.on('disconnect', () => {
//         let disconnectedUserId = null;

//         for (let userId in onlineUsers) {
//             if (onlineUsers[userId].socketId === socket.id) {
//                 onlineUsers[userId].status = 'offline'; 
//                 onlineUsers[userId].socketId = null;
//                 disconnectedUserId = userId;
//                 break;
//             }
//         }

//         if (disconnectedUserId) {
//             // Atualizar a lista de usuários online
//             io.emit('update online users', Object.values(onlineUsers));
//         }

//         console.log('Usuário desconectado:', socket.id);
//     });
// });

// // 🚀 Iniciar servidor na porta 6001
// server.listen(6001, '0.0.0.0', () => {
//     console.log('Servidor rodando em produção na porta 6001');
// });

import express from 'express';
import https from 'https';
import fs from 'fs';
import { Server } from 'socket.io';
import cors from 'cors';
import axios from 'axios';

const app = express();

// Caminhos para os certificados SSL
const options = {
    cert: fs.readFileSync('/etc/letsencrypt/live/proconline.com.br/fullchain.pem'),
    key: fs.readFileSync('/etc/letsencrypt/live/proconline.com.br/privkey.pem')
};

// Criar o servidor HTTPS
const server = https.createServer(options, app);

// Criar o servidor Socket.io
const io = new Server(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

app.use(cors());
app.use(express.json());

io.on('connection', (socket) => {
    console.log('Usuário conectado:', socket.id);

    socket.on('chat message', async (data) => {
        const { content, sender_id } = data;

        try {
            const sentAt = new Date().toISOString();

            const response = await axios.post('https://proconline.com.br/api/messages', {
                content,
                sender_id,
                sent_at: sentAt
            });
            
            const userResponse = await axios.get(`https://proconline.com.br/api/users/${sender_id}`);
            const user = userResponse.data;

            io.emit('chat message', {
                content: response.data.content,
                sender_id: response.data.sender_id,
                sent_at: response.data.sent_at,
                user: {
                    id: user.id,
                    name: user.name
                }
            });
        } catch (error) {
            console.error('Erro ao salvar mensagem:', error.message);
        }
    });

    socket.on('disconnect', () => {
        console.log('Usuário desconectado:', socket.id);
    });
});

// Iniciar o servidor na porta 6002
server.listen(6001, '0.0.0.0', () => {
    console.log('Servidor rodando na porta 6001');
});
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

// io.on('connection', (socket) => {
//     console.log('Usuário conectado:', socket.id);

//     socket.on('chat message', async (data) => {
//         const { content, sender_id } = data;

//         try {
//             // Obter a hora atual no momento do envio
//             const sentAt = new Date().toISOString();  // Captura a hora atual em formato ISO 8601

//             // Salvar a mensagem no banco via API Laravel
//             //const response = await axios.post('http://localhost:8990/api/messages', {
//             const response = await axios.post('http://proconline.com.br/api/messages', {
//                 content,
//                 sender_id,
//                 sent_at: sentAt // Envia a hora com a mensagem
//             });
            
//             // Buscar os dados completos do usuário
//             //const userResponse = await axios.get(`http://localhost:8990/api/users/${sender_id}`);
//             const userResponse = await axios.get(`http://proconline.com.br/api/users/${sender_id}`);
//             const user = userResponse.data;

//             // Emite a mensagem com os dados do usuário completos, incluindo a hora de envio
//             io.emit('chat message', {
//                 content: response.data.content,
//                 sender_id: response.data.sender_id,
//                 sent_at: response.data.sent_at,  // Enviando a hora de envio
//                 user: {
//                     id: user.id,
//                     name: user.name
//                 }
//             });
//         } catch (error) {
//             console.error('Erro ao salvar mensagem:', error.message);
//         }
//     });

//     socket.on('disconnect', () => {
//         console.log('Usuário desconectado:', socket.id);
//     });
// });

// server.listen(6002, '0.0.0.0', () => {
//     console.log('Servidor rodando na porta 6002');
// });


//PRODUCAO
import express from 'express';
import https from 'https';
import fs from 'fs';
import { Server } from 'socket.io';
import cors from 'cors';
import axios from 'axios';

const app = express();

// Definindo os caminhos dos certificados SSL
const options = {
    key: fs.readFileSync('/etc/letsencrypt/live/proconline.com.br/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/proconline.com.br/fullchain.pem')
};

// Criando o servidor HTTPS
const server = https.createServer(options, app);
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
            // Obter a hora atual no momento do envio
            const sentAt = new Date().toISOString();  // Captura a hora atual em formato ISO 8601

            // Salvar a mensagem no banco via API Laravel
            const response = await axios.post('https://proconline.com.br/api/messages', {
                content,
                sender_id,
                sent_at: sentAt // Envia a hora com a mensagem
            });
            
            // Buscar os dados completos do usuário
            const userResponse = await axios.get(`https://proconline.com.br/api/users/${sender_id}`);
            const user = userResponse.data;

            // Emite a mensagem com os dados do usuário completos, incluindo a hora de envio
            io.emit('chat message', {
                content: response.data.content,
                sender_id: response.data.sender_id,
                sent_at: response.data.sent_at,  // Enviando a hora de envio
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

// Iniciando o servidor na porta 6002
server.listen(6002, '0.0.0.0', () => {
    console.log('Servidor rodando na porta 6002');
});

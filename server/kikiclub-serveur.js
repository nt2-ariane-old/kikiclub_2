#!/usr/bin/env nodejs
require('dotenv').config()

const express = require('express');
const http = require("http");


const port = process.env.PORT || 4001;

const app = express()

//Sécurité
var helmet = require('helmet');
app.use(helmet());

app.disable('x-powered-by');

var session = require('express-session');
app.set('trust proxy', 1) // trust first proxy
app.use(session({
    secret: 's3Cur3',
    name: 'sessionId',
})
);

const cors = require('cors')
app.use(cors({
    origin: ['http://www.doutreguay.com', "http://kikiclub.doutreguay.com", 'http://doutreguay.com', 'http://localhost:3000', 'https://www.kikicode.club', 'https://kikinumerique.wixsite.com/kikiclubsandbox'],
    default: 'http://www.doutreguay.com'
}));

app.get('/', function (req, res) {
    res.send('Vous êtes à l\'accueil, que puis-je pour vous ?');
})

app.use(express.json())

//Serveur
const server = http.createServer(app)

//Socket
// const socketIo = require("socket.io");
// const io = socketIo(server); // < Interesting!

// io.on("connection", (socket) => {
//     socket.on('message', (message) => {
//         console.log(message);
//         socket.broadcast.emit('message', message);
//     });
// });

//DB

const avatarsRouter = require('./routes/avatars')
app.use('/api', avatarsRouter)
const memberWorkshopRouter = require('./routes/member_workshops')
app.use('/api', memberWorkshopRouter)
const membersRouter = require('./routes/members')
app.use('/api', membersRouter)
const robotRouter = require('./routes/robots')
app.use('/api', robotRouter)
const userRouter = require('./routes/users')
app.use('/api', userRouter)
const workshopsRouter = require('./routes/workshops')
app.use('/api', workshopsRouter)
const WorkshopFiltersRouter = require('./routes/workshop_filters')
app.use('/api', WorkshopFiltersRouter)
const MediasRouter = require('./routes/medias')
app.use('/api', MediasRouter)


//Start Serveur
server.listen(port, () => console.log(`Listening on port ${port}`));

const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Serve static files (optional)
app.use(express.static('public'));

// Handle Socket.IO connections
io.on('connection', (socket) => {
    console.log('A user connected: ' + socket.id);

    // Listen for chat messages
    socket.on('chat message', (data) => {
        console.log('Message from ' + data.sender + ': ' + data.message);
        // Broadcast the message to the recipient(s)
        io.to(data.receiver).emit('chat message', data);
    });

    // Disconnect handler
    socket.on('disconnect', () => {
        console.log('User disconnected: ' + socket.id);
    });
});
socket.on('chat message', (data) => {
     // AJAX call to PHP to save the message
     fetch('save_message.php', {
         method: 'POST',
         body: JSON.stringify(data),
         headers: { 'Content-Type': 'application/json' }
     })
     .then(response => response.json())
     .then(responseData => {
         // Optionally handle the response
     })
     .catch(error => console.error(error));
 
     // Broadcast the message to the receiver
     io.to(data.receiver).emit('chat message', data);
 });
 
// Start the server
const port = 3000;
server.listen(port, () => {
    console.log(`Server running on http://localhost:${port}`);
});

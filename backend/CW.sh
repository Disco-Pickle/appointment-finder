#!/bin/bash
tmux new-session -d -s PHP-backend
# Create a window for each folder and a pane for each file
tmux new-window -t PHP-backend:1 -n api
tmux send-keys -t PHP-backend:1 'nvim ./api/index.php' C-m

tmux new-window -t PHP-backend:2 -n config
tmux send-keys -t PHP-backend:2 'nvim ./config/init.php' C-m

tmux new-window -t projct:3 -n controllers
tmux split-window -v -t PHP-backend:3
tmux send-keys -t PHP-backend:3.1 'nvim ./controllers/AppointmentController.php' C-m
tmux send-keys -t PHP-backend:3.2 'nvim ./controllers/UserController.php' C-m
tmux split-window -v -t PHP-backend:3
tmux send-keys -t PHP-backend:3.3 'nvim ./controllers/VoteController.php' C-m

tmux new-window -t PHP-backend:4 -n models
tmux split-window -v -t PHP-backend:4
tmux send-keys -t PHP-backend:4.1 'nvim ./models/Appointment.php' C-m
tmux send-keys -t PHP-backend:4.2 'nvim ./models/Person.php' C-m

tmux new-window -t PHP-backend:5 -n utilities
tmux split-window -v -t PHP-backend:5
tmux send-keys -t PHP-backend:5.1 'nvim ./utilities/Database.php' C-m
tmux send-keys -t PHP-backend:5.2 'nvim ./utilities/Validator.php' C-m

# Attach to the session
tmux attach -t PHP-backend

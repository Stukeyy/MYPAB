#!/bin/bash

# new ssh key pair set up on server and public added to gitlab profile
# server repos updated to ssh urls using new key pair to connect without password

cd ./project/backend
git fetch origin
git pull origin


cd ../frontend
git fetch origin
git pull origin
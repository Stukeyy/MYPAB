#!/bin/bash

# new ssh key pair set up on server and public added to gitlab profile
# server repos updated to ssh urls using new key pair to connect without password

# originally was building in the frontend project pipeline and saving as artifacts
# then downloading these artifacts in backend project pipeline
# integrating them and then recommiting
# after new artifacts downloaded, integrated and commited
# deploys and pulls latests changes

# however remote repo would always be a commit ahead of local as new artifacts integrated and commited in pipeline
# had to pull latest remote changes locally before pushing which would trigger another pipeline merging remote to local commits
# it worked but was an inefficient way to do task, check new frontend deploy file for refined way

# cd ./project/backend
# git fetch origin
# git pull origin


# cd ../frontend
# git fetch origin
# git pull origin
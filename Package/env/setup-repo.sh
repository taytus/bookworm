#!/bin/bash
# GitHub API Token
GH_API_TOKEN='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'
# GitHub User Name
GH_USER='taytus'
# Variable to store first argument to setup-repo, the repo name. Will be used as GH repo name, too.
NEW_REPO_NAME=$1
# Store current working Env.
CURRENT_DIR=$PWD
# Project Env can be passed as second argument to setup-repo, or will default to current working Env.
PROJECT_DIR=${2:-$CURRENT_DIR}
# GitHub repos Create API call
curl -H "Authorization: token $GH_API_TOKEN" https://api.github.com/user/repos -d '{"name": "'"${NEW_REPO_NAME}"'"}'
git init $PROJECT_DIR
# Initialize Git in project Env, and add the GH repo remote.
git -C $PROJECT_DIR remote add origin git@github.com:$GH_USEr/$NEW_REPO_NAME.git

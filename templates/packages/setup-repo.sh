#!/bin/bash
# GitHub API Token
GH_API_TOKEN='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'
# GitHub User Name
GH_USER='taytus'
# Variable to store first argument to setup-repo, the repo name. Will be used as GH repo name, too.
NEW_REPO_NAME=$1
# Store current working $$package_name$$.
CURRENT_DIR=$PWD
# Project $$package_name$$ can be passed as second argument to setup-repo, or will default to current working $$package_name$$.
PROJECT_DIR=${2:-$CURRENT_DIR}
# GitHub repos Create API call
curl -H "Authorization: token $GH_API_TOKEN" https://api.github.com/user/repos -d '{"name": "'"${NEW_REPO_NAME}"'"}'
git init $PROJECT_DIR
# Initialize Git in project $$package_name$$, and add the GH repo remote.
git -C $PROJECT_DIR remote add origin git@github.com:$GH_USEr/$NEW_REPO_NAME.git

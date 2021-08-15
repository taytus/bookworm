#!/bin/bash
# Ask the user for the repo name

echo What's the repository's name?

read varname

git init
git add .
git commit -m "first commit"
git remote add origin git@github.com:taytus/$varname.git
git tag -a v1.0 -m "first tag"
git push -u origin --tags master

echo repo has been initializaded.


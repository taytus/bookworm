#!/bin/bash

git init
git add .
git commit -m "first commit"
git remote add origin git@github.com:taytus/$1.git
git tag -a v1.0 -m "first tag"
git push -u origin --tags master

echo repo has been initializaded.


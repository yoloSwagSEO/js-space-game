#!/bin/bash
read -p "Commit description: " desc
git add . && \
git add -u && \
git status
git commit -m "$desc" && \
git push
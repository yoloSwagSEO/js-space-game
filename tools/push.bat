#!/bin/bash
read -p "Commit description: " desc
git add . && \
git add -u && \
git status
read -r -p "It hard to revert a commit! [Y/n]" response
response=${response,,} # tolower
if [[ $response =~ ^(yes|y| ) ]] | [ -z $response ]; then
	git commit -m "$desc" && \
	git push
fi
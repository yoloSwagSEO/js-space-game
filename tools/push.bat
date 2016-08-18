#!/bin/bash
echo "$(tput setaf 3)Hallo Master,"
while read -p "$(tput setaf 3)please give your creation a name: " desc; do
     if [[ -z "${desc}" ]]; then
          echo "$(tput setaf 1)you have to name it or we never find it again!"
     else
          echo "$(tput setaf 1)burning the name on its ass..."
          break
     fi
done
echo "$(tput setaf 3) "
git add . && \
git add -u && \
git status
read -r -p "$(tput setaf 1)sure you want to set this monster free? [Y/n]" response
response=${response,,} # tolower
if [[ $response =~ ^(yes|y| ) ]] | [ -z $response ]; then
	git commit -m "$desc" && \
	git push
	echo '$(tput setaf 2)the monster is free... lets hope you did it right this time!'
else
	echo ''
	echo "$(tput setaf 1)ok I get the monster back in its cage!"
fi
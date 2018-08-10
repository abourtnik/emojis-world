#!/bin/bash

curl -X PUT "localhost:9200/emojis-world/" -H 'Cache-Control: no-cache' -H 'Content-Type: application/json' -d @./jsons/update_synonyms.json
printf "\n"

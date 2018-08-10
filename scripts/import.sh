#!/bin/bash

curl -X POST "localhost:9200/emojis-world/emojis/_bulk" -H 'Cache-Control: no-cache' -H 'Content-Type: application/json' --data-binary @./jsons/import.json
printf "\n"

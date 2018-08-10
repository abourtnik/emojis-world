#!/bin/bash

curl -X POST "localhost:9200/emojis-world/_search" -H 'Cache-Control: no-cache' -H 'Content-Type: application/json' -d '{"query" : {"match_all" : {}}}'
printf "\n"
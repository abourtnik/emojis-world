#!/bin/bash

curl -X POST "localhost:9200/emojis-world/_$1"
printf "\n"

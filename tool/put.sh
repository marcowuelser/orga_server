#!/bin/bash

source ./init.sh
url="$URL/$1"

echo "$url \n$AUTH \n"
curl -i -H "$CONT" -H "$AUTH" -X PUT -d "$2" $url
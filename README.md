<h1 align="center">
  <a href="https://www.emojisworld.fr">
    <img src="https://www.emojisworld.fr/img/logo.png" alt="Emoji World logo" height="200">
  </a>
  <br>
  Emojis World REST API
  <br>
</h1>

<h3 align="center">Open Source REST API for emojis </h3>

<p align="center">
  <a href="#categories">Categories</a> •
  <a href="#endpoints">Endpoints</a> •
  <a href="#http-response-codes">HTTP Response Codes</a> •
  <a href="#technical-detail">Technical detail and API Rate Limiting</a> •
  <a href="#contributing">Contributing</a> •
  <a href="#license">License</a> •
  <a href="#credits">Credits</a>
</p>

## Categories

| ID | Name | Emojis Count
| ------------- | ----- | ------------- |
| 1 | Smileys & People |  1277 |
| 2 | Animals & Nature |  113 |
| 3 | Food & Drink |  101 |
| 4 | Travel & Places |  199 |
| 5 | Activities |  67 |
| 6 | Objects |  166 |
| 7 | Symbols |  206 |
| 8 | Flags |  265 |


## Endpoints

<p align="center">
  <a href="#api-index">Index</a> •
  <a href="#search-emojis">Search emojis </a> •
  <a href="#random-emojis">Random emojis </a> •
  <a href="#popular-emojis">Popular emojis </a> •
  <a href="#all-categories-and-sub-categories">Categories</a> •
  <a href="#emoji-by-specific-id ">Search by id</a>
</p>

### API index
```http
GET https://api.emojisworld.fr/v1
```

#### Sample Response
```json
{
  "message": "Welcome on Emojis World API ( version 1) !!"
}
```

### Search emojis
```http
GET https://api.emojisworld.fr/v1/search
```

#### Query String Options

| Query Strings  	| Type              	| Description                                         	| Example                	|
|----------------	|-------------------	|-----------------------------------------------------	|------------------------	|
| q              	| String - Required 	| A search word (only in english)                     	| `q=happy`              	|
| limit          	| Integer           	| Fetch up to a specified number of results (max: 50) 	| `limit=25`             	|
| categories     	| List of Integers  	| Filter the response by categories ids               	| `categories=1,2,3`     	|
| sub_categories 	| List of Integers  	| Filter the response by sub categories ids           	| `sub_categories=1,2,3` 	|

#### Example
```http
https://api.emojisworld.fr/v1/search?q=baby&categories=1,2,3&sub_categories=10,33&limit=10
```

#### Sample Response
```json
{  
   "totals": 2,
   "results": [  
      {  
         "id": 1467,
         "name": "baby bottle",
         "emoji": "🍼",
         "unicode": "1F37C",
         "category": {  
            "id": 3,
            "name": "Food & Drink"
         },
         "sub_category" : {  
            "id": 33,
            "name": "drink"
         },
         "children": []
      },
      {  
         "id": 113,
         "name": "baby",
         "emoji": "👶",
         "unicode": "1F476",
         "category": {  
            "id" : 1,
            "name": "Smileys & People"
         },
         "sub_category":{  
            "id": 10,
            "name": "person"
         },
         "children":[
           {
            "id": 114,
            "name": "baby: light skin tone",
            "emoji": "👶🏻",
            "unicode": "1F476 1F3FB"
           },
           {
             "id": 115,
             "name": "baby: medium-light skin tone",
             "emoji": "👶🏼",
             "unicode": "1F476 1F3FC"
           },
           {
             "id": 116,
             "name": "baby: medium skin tone",
             "emoji": "👶🏽",
             "unicode": "1F476 1F3FD"
           },
           {
             "id": 117,
             "name": "baby: medium-dark skin tone",
             "emoji": "👶🏾",
             "unicode": "1F476 1F3FE"
           },
           {
             "id": 118,
             "name": "baby: dark skin tone",
             "emoji": "👶🏿",
             "unicode": "1F476 1F3FF"
           }
         ]
      }
   ]
}
```

### Random emojis
```http
GET https://api.emojisworld.fr/v1/random
```

#### Query String Options

| Query Strings  	| Type             	| Description                                         	| Example                	|
|----------------	|------------------	|-----------------------------------------------------	|------------------------	|
| limit          	| Integer          	| Fetch up to a specified number of results (max: 50) 	| `limit=25`             	|
| categories     	| List of Integers 	| Filter the response by categories ids               	| `categories=1,2,3`     	|
| sub_categories 	| List of Integers 	| Filter the response by sub categories ids           	| `sub_categories=1,2,3` 	|

#### Example
```http
GET https://api.emojisworld.fr/v1/random?&categories=1,2,3&sub_categories=1,2,3&limit=2
```

#### Sample Response
```json
{
  "totals": 2,
  "results": [
    {
      "id": 8,
      "name": "grinning squinting face",
      "emoji": "😆",
      "unicode": "1F606",
      "category": {
        "id": 1,
        "name": "Smileys & People"
      },
      "sub_category": {
        "id": 1,
        "name": "face-positive"
      },
      "children": []
    },
    {
      "id": 25,
      "name": "expressionless face",
      "emoji": "😑",
      "unicode": "1F611",
      "category": {
        "id": 1,
        "name": "Smileys & People"
      },
      "sub_category": {
        "id": 2,
        "name": "face-neutral"
      },
      "children": []
    }
  ]
}
```

### Popular emojis
```http
GET https://api.emojisworld.fr/v1/popular
```

#### Query String Options

| Query Strings  	| Type             	| Description                                         	| Example                	|
|----------------	|------------------	|-----------------------------------------------------	|------------------------	|
| limit          	| Integer          	| Fetch up to a specified number of results (max: 50) 	| `limit=25`             	|
| categories     	| List of Integers 	| Filter the response by categories ids               	| `categories=1,2,3`     	|
| sub_categories 	| List of Integers 	| Filter the response by sub categories ids           	| `sub_categories=1,2,3` 	|

#### Example
```http
GET https://api.emojisworld.fr/v1/popular?categories=1,2,3&sub_categories=1,2,3&limit=2
```

#### Sample Response
```json
{
  "totals": 2,
  "results": [
    {
      "id": 3,
      "name": "face with tears of joy",
      "emoji": "😂",
      "unicode": "1F602",
      "count": 13,
      "category": {
        "id": 1,
        "name": "Smileys & People"
      },
      "sub_category": {
        "id": 1,
        "name": "face-positive"
      },
      "children": [
        
      ]
    },
    {
      "id": 2,
      "name": "beaming face with smiling eyes",
      "emoji": "😁",
      "unicode": "1F601",
      "count": 9,
      "category": {
        "id": 1,
        "name": "Smileys & People"
      },
      "sub_category": {
        "id": 1,
        "name": "face-positive"
      },
      "children": [

      ]
    }
  ]
}
```

### All categories and sub categories 
```http
GET https://api.emojisworld.fr/v1/categories
```

#### Sample Response
```json
{  
   "totals":8,
   "results":[  
      {  
         "id":1,
         "name":"Smileys & People",
         "emojis_count":1277,
         "sub_categories":[  
            {  
               "id":1,
               "name":"face-positive",
               "emojis_count":21
            }
         ]
      }
   ]
}
```

### Emoji by specific id 
```http
GET https://api.emojisworld.fr/v1/emojis/{id}
```
#### Sample Response
```json
{
  "id": 3,
  "name": "face with tears of joy",
  "emoji": "😂",
  "unicode": "1F602",
  "category": {
    "id": 1,
    "name": "Smileys & People"
  },
  "sub_category": {
    "id": 1,
    "name": "face-positive"
  },
  "children": [

  ],
  "parent": null
}
```

## HTTP Response Codes
| Code  | Description |
| ------------- | ------------- |
| 200  | Success |
| 400  | Bad Request |
| 401  | Unauthorized |
| 403  | Access Forbidden |
| 404  | Not Found |
| 429  | Too Many Requests |
| 500  | Internal Server Error	 |

## Technical detail

API Rate Limiting : **500 REQUESTS / DAY / IP**.

| Header | Description | Example |
| ------------- | ------------- | ------------- |
| X-Rate-Limit-Limit  | The maximum number of request you-re permitted to make per period of 1 day | 500 |
| X-Rate-Limit-Remaining | Your current number of request | 100 |
| X-Rate-Limit-Reset  | The time at which the rate limit resets | Tue Aug 17 2021 17:43:28 GMT+0200 |

* API is using Node.js with the Express.js framework
* All emojis data are stored in a MySQL and Typesense databases

## Contributing

**I search contributors for help me to complete and correct keywords for each emoji. This will allow for a better and more relevant search.**

**You can find the complete list of emojis and associated keywords in [emojis.json](https://github.com/abourtnik/emojis-world/blob/master/scripts/emojis.json) file.**

We encourage you to contribute to Emojis World !! Please check out the [Contributing to Emojis World guide](https://github.com/abourtnik/emojis-world/blob/master/contributing.md) for guidelines about how to proceed. Join us!

Trying to report a possible security vulnerability in Emojis World ? Consider using email : 
**contact@antonbourtnik.fr** with clear description of security vulnerability.

## License
Emojis World is made available under the [MIT License](http://www.opensource.org/licenses/mit-license.php).

## Credits
Emojis World is created and maintained by [Anton Bourtnik](https://github.com/abourtnik)
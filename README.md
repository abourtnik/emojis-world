<h1 align="center">
  <a href="https://emojisworld.io">
    <img src="http://emojisworld.local:81/static/media/logo.32896e20.png" alt="Emoji World logo" height="200">
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
  <a href="#technical-detail">Tecnhical detail</a> •
  <a href="#contributing">Contributing</a> •
  <a href="#license">License</a> •
  <a href="#credits">Credits</a>
</p>

## Categories

| ID | Name | Emojis Count
| ------------- | ----- | ------------- |
| 1 | Smileys & People |  408 |
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
  <a href="#all-categories-and-sub-categories">Categories</a> •
  <a href="#emoji-by-specific-id ">Search by id</a>
</p>

### API index
```http
GET https://api.emojisworld.io/v1
```

#### Sample Response
```json
{
  "message": "Welcome on Emojis World API ( version 1) !!"
}
```

### Search emojis
```http
GET https://api.emojisworld.io/v1/search
```

#### Query String Options

| Query Strings | Type | Description | Example |
| ------------- | ----- | ------------- | ------------- |
| q | String | A search word (only in english)  | `q=happy` |
| limit | Integer | Fetch up to a specified number of results (max: 50)  | `limit=25` |
| category | Integer |  Filter the response by category_id  | `category=1` |
| sub_category | Integer |  Filter the response by sub_category_id  | `sub_category=1` |

#### Example
```http
GET https://api.emojisworld.io/v1/search?q=happy&category=1&sub_category=1&limit=2
```

#### Sample Response
```json
{  
   "totals":20,
   "results":[  
      {  
         "id":97,
         "name":"grinning cat face with smiling eyes",
         "emoji":"😸",
         "unicode":"1F638",
         "score":0,
         "category":{  
            "id":1,
            "name":"Smileys & People"
         },
         "sub_category":{  
            "id":7,
            "name":"cat-face"
         },
         "childrens":[  

         ]
      },
      {  
         "id":2,
         "name":"beaming face with smiling eyes",
         "emoji":"😁",
         "unicode":"1F601",
         "score":1,
         "category":{  
            "id":1,
            "name":"Smileys & People"
         },
         "sub_category":{  
            "id":1,
            "name":"face-positive"
         },
         "childrens":[  

         ]
      }
   ]
}
```

### Random emojis
```http
GET https://api.emojisworld.io/v1/random
```

#### Query String Options

| Query Strings | Type | Description | Example |
| ------------- | ----- | ------------- | ------------- |
| limit | Integer | Fetch up to a specified number of results (max: 50)  | `limit=25` |
| category | Integer |  Filter the response by category_id  | `category=1` |
| sub_category | Integer |  Filter the response by sub_category_id  | `sub_category=1` |

#### Example
```http
GET https://api.emojisworld.io/v1/random?category=1&sub_category=1&limit=2
```

#### Sample Response
```json
{  
   "totals":50,
   "results":[  
      {  
         "id":1217,
         "name":"green heart",
         "emoji":"💚",
         "unicode":"1F49A",
         "score":0,
         "category":{  
            "id":1,
            "name":"Smileys & People"
         },
         "sub_category":{  
            "id":18,
            "name":"emotion"
         },
         "childrens":[  

         ]
      },
      {  
         "id":1317,
         "name":"koala",
         "emoji":"🐨",
         "unicode":"1F428",
         "score":0,
         "category":{  
            "id":2,
            "name":"Animals & Nature"
         },
         "sub_category":{  
            "id":20,
            "name":"animal-mammal"
         },
         "childrens":[  

         ]
      }
   ]
}
```


### All categories and sub categories 
```http
GET https://api.emojisworld.io/v1/categories
```

#### Sample Response
```json
{  
   "totals":8,
   "results":[  
      {  
         "id":1,
         "name":"Smileys & People",
         "emojis_count":408,
         "first_emoji":{  
            "id":1,
            "name":"grinning face",
            "emoji":"😀",
            "unicode":"1F600",
            "score":0,
            "category":{  
               "id":1,
               "name":"Smileys & People"
            },
            "sub_category":{  
               "id":1,
               "name":"face-positive"
            },
            "childrens":[  

            ]
         },
         "sub_categories":[  
            {  
               "id":1,
               "name":"face-positive",
               "emojis_count":21,
               "first_emoji":{  
                  "id":1,
                  "name":"grinning face",
                  "emoji":"😀",
                  "unicode":"1F600",
                  "score":0,
                  "category":{  
                     "id":1,
                     "name":"Smileys & People"
                  },
                  "sub_category":{  
                     "id":1,
                     "name":"face-positive"
                  },
                  "childrens":[  

                  ]
               }
            }
         ]
      }
   ]
}
```

### Emoji by specific id 
```http
GET https://api.emojisworld.io/v1/emojis/id
```
#### Sample Response
```json
{  
   "totals":1,
   "results":[  
      {  
         "id":3,
         "name":"face with tears of joy",
         "emoji":"😂",
         "unicode":"1F602",
         "score":0,
         "category":{  
            "id":1,
            "name":"Smileys & People"
         },
         "sub_category":{  
            "id":1,
            "name":"face-positive"
         },
         "childrens":[  

         ]
      }
   ]
}
```

## HTTP Response Codes
| Code  | Description |
| ------------- | ------------- |
| 200  | Success |
| 400  | Bad Request |
| 401  | Unauthorized |
| 403  | Bad Request |
| 404  | Returns  `Not Found` |
| 500  | Internal Server Error	 |

## Tecnhical detail

* API is using Node.js with the Express.js framework
* All emojis data are stored in a Elasticsearch database
* User data are stored in MongoDB database

## Contributing

We encourage you to contribute to Emojis World !! Please check out the [Contributing to Emojis World guide](https://github.com/abourtnik/emojis-world/blob/master/contributing.md) for guidelines about how to proceed. Join us!

Trying to report a possible security vulnerability in Emojis World ? Send an email to 
**contact@emojisworld.io** with clear description of security vulnerability.

## License
Emojis World is made available under the [MIT License](http://www.opensource.org/licenses/mit-license.php).

## Credits
Emojis World is created and maintained by [Anton Bourtnik](https://github.com/abourtnik)
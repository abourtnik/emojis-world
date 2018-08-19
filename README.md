<h1 align="center">
  <a href="https://emojisworld.io">
    <img src="https://www.emojisworld.io/img/logo.png" alt="Emoji World logo" height="300">
  </a>
  <br>
  Emojis World REST API
  <br>
</h1>

<h3 align="center">Open Source REST API for emojis </h3>

<p align="center">
  <a href="#endpoints">Endpoints</a> •
  <a href="#http-response-codes">HTTP Response Codes</a> •
  <a href="#contributing">Contributing</a> •
  <a href="#license">License</a> •
  <a href="#credits">Credits</a>
</p>

## Endpoints

<p align="center">
  <a href="#api-index">Index</a> •
  <a href="#search-emojis">Search emojis </a> •
  <a href="#random-emojis">Random emojis </a> •
  <a href="#all-categories-and-sub-categories">Categories</a> •
  <a href="#search-by-category-id"> Search by category id </a>  •
  <a href="#search-by-sub-category-id ">Search by sub category id</a>  •
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
GET https://api.emojisworld.io/v1/search?q=happy&category=1&subcategory=1&limit=2
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

#### Example
```http
GET https://api.emojisworld.io/v1/random?category=1&subcategory=1&limit=2
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

#### Query String Options

| Query Strings | Type | Description | Example |
| ------------- | ----- | ------------- | ------------- |
| limit | Integer | Fetch up to a specified number of results (max: 50)  | `limit=25` |
| category | Integer |  Filter the response by category_id  | `category=1` |
| sub_category | Integer |  Filter the response by sub_category_id  | `sub_category=1` |


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

### Search by category id
```http
GET https://api.emojisworld.io/v1/category/id
```

#### Query String Options

| Query Strings | Type | Description | Example |
| ------------- | ----- | ------------- | ------------- |
| limit | Integer | Fetch up to a specified number of results (max: 50)  | `limit=25` |

#### Sample Response
```json
{  
   "totals":408,
   "results":[  
      {  
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

### Search by sub category id 
```http
GET https://api.emojisworld.io/v1/sub_category/id
```

#### Query String Options

| Query Strings | Type | Description | Example |
| ------------- | ----- | ------------- | ------------- |
| limit | Integer | Fetch up to a specified number of results (max: 50)  | `limit=25` |

#### Sample Response
```json
{  
   "totals":10,
   "results":[  
      {  
         "id":113,
         "name":"baby",
         "emoji":"👶",
         "unicode":"1F476",
         "score":0,
         "category":{  
            "id":1,
            "name":"Smileys & People"
         },
         "sub_category":{  
            "id":10,
            "name":"person"
         },
         "childrens":[  
            {  
               "id":114,
               "name":"baby: light skin tone",
               "emoji":"👶🏻",
               "unicode":"1F476 1F3FB",
               "score":0,
               "category":{  
                  "id":1,
                  "name":"Smileys & People"
               },
               "sub_category":{  
                  "id":10,
                  "name":"person"
               }
            },
            {  
               "id":115,
               "name":"baby: medium-light skin tone",
               "emoji":"👶🏼",
               "unicode":"1F476 1F3FC",
               "score":0,
               "category":{  
                  "id":1,
                  "name":"Smileys & People"
               },
               "sub_category":{  
                  "id":10,
                  "name":"person"
               }
            },
            {  
               "id":116,
               "name":"baby: medium skin tone",
               "emoji":"👶🏽",
               "unicode":"1F476 1F3FD",
               "score":0,
               "category":{  
                  "id":1,
                  "name":"Smileys & People"
               },
               "sub_category":{  
                  "id":10,
                  "name":"person"
               }
            },
            {  
               "id":117,
               "name":"baby: medium-dark skin tone",
               "emoji":"👶🏾",
               "unicode":"1F476 1F3FE",
               "score":0,
               "category":{  
                  "id":1,
                  "name":"Smileys & People"
               },
               "sub_category":{  
                  "id":10,
                  "name":"person"
               }
            },
            {  
               "id":118,
               "name":"baby: dark skin tone",
               "emoji":"👶🏿",
               "unicode":"1F476 1F3FF",
               "score":0,
               "category":{  
                  "id":1,
                  "name":"Smileys & People"
               },
               "sub_category":{  
                  "id":10,
                  "name":"person"
               }
            }
         ]
      }
   ]
}
```

### Emoji by specific id 
```http
GET https://api.emojisworld.io/v1/emoji/{id}
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
| 200  | Returns all emojis by default |
| 404  | Returns  `Not Found` |

## Tecnhical detail

* API is using Node.js with the Express.js framework
* All emojis data are stored in a Elastic Search database
* Request data are stored in MongoDB database

## Contributing

We encourage you to contribute to Emojis World! Please check out the [Contributing to Emojis World guide](https://github.com/abourtnik/emojis-world/blob/master/contributing.md) for guidelines about how to proceed. Join us!

Trying to report a possible security vulnerability in Emojis World ? Send an email to 
**contact@emojisworld.io** with clear description of security vulnerability.

## License
Emojis World is made available under the [MIT License](http://www.opensource.org/licenses/mit-license.php).

## Credits
Emojis World is created and maintained by [Anton Bourtnik](https://github.com/abourtnik)
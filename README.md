<h1 align="center">
  <a href="https://www.emojisworld.fr">
    <img src="https://www.emojisworld.fr/img/logo.png" alt="Emoji World logo" height="200">
  </a>
  <br>
  Emojis World REST API
  <br>
</h1>

<h3 align="center">Open Source REST API for emojis - 3677 Emojis Availaible  </h3>

<p align="center">
  <a href="#categories">Categories and Versions</a> •
  <a href="#endpoints">Endpoints</a> •
  <a href="#technical-detail">Technical detail and API Rate Limiting</a> •
  <a href="#contributing">Contributing</a> •
  <a href="#license">License</a> •
  <a href="#credits">Credits</a> •
  <a href="#support-project">Support Project</a>
</p>

## Categories and Versions

<table border="0">
<tr>
<td>

| ID | Name | Emojis Count 
| ------------- | ----- |--------------|
| 1 | Smileys & People | 168          |
| 2 | People & Body | 2167         |
| 3 | Component | 10           |
| 4 | Animals & Nature | 150          |
| 5 | Food & Drink | 135          |
| 6 | Travel & Places | 218          |
| 7 | Activities | 85           |
| 8 | Objects | 258          |
| 9 | Symbols | 223          |
| 10 | Flags | 269          |
</td>
<td>

| Version | Emojis Count 
|---------|--------------|
| 0.6     | 719          |
| 0.7     | 139          |
| 1.0     | 490          |
| 2.0     | 292          |
| 3.0     | 162          |
| 4.0     | 611          |
| 5.0     | 239          |
| 11.0    | 161          |
| 12.0    | 230          |
| 12.1    | 168          |
| 13.0    | 117          |
| 13.1    | 217          |
| 14.0    | 107          |
| 15.0    | 30           |
</td>
 </tr>
</table>

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

| Query Strings  	| Type              	            | Description                                         	| Example                	|
|----------------	|---------------------------------	|-----------------------------------------------------	|------------------------	|
| q              	| String - **Required** 	        | A search word (only in english)                     	| `q=happy`              	|
| limit          	| Integer - *Optional*           	| Fetch up to a specified number of results (max: 50) 	| `limit=25`             	|
| categories     	| List of Integers - *Optional* 	| Filter response by categories ids               	    | `categories=1,2,3`     	|
| sub_categories 	| List of Integers - *Optional*  	| Filter response by sub_categories ids           	    | `sub_categories=1,2,3` 	|
| versions 	        | List of Floats - *Optional*  	    | Filter response by specifics versions          	    | `versions=1.0,13.1` 	    |

#### Example
```http
https://api.emojisworld.fr/v1/search?q=party&categories=7,8,6&sub_categories=61,66,63&versions=0.6,13.0
```

#### Sample Response
```json
{
  "totals": 4,
  "results": [
    {
      "id": 1691,
      "name": "party popper",
      "emoji": "🎉",
      "unicode": "1F389",
      "version": "0.6",
      "category": {
        "id": 7,
        "name": "Activities"
      },
      "sub_category": {
        "id": 61,
        "name": "event"
      },
      "children": [

      ]
    },
    {
      "id": 1248,
      "name": "dress",
      "emoji": "👗",
      "unicode": "1F457",
      "version": "0.6",
      "category": {
        "id": 8,
        "name": "Objects"
      },
      "sub_category": {
        "id": 66,
        "name": "clothing"
      },
      "children": [

      ]
    },
    {
      "id": 1718,
      "name": "bowling",
      "emoji": "🎳",
      "unicode": "1F3B3",
      "version": "0.6",
      "category": {
        "id": 7,
        "name": "Activities"
      },
      "sub_category": {
        "id": 63,
        "name": "sport"
      },
      "children": [

      ]
    },
    {
      "id": 1687,
      "name": "fireworks",
      "emoji": "🎆",
      "unicode": "1F386",
      "version": "0.6",
      "category": {
        "id": 7,
        "name": "Activities"
      },
      "sub_category": {
        "id": 61,
        "name": "event"
      },
      "children": [

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

| Query Strings  	| Type             	                | Description                                         	| Example                	|
|----------------	|-------------------------------	|-----------------------------------------------------	|------------------------	|
| limit          	| Integer - *Optional*          	| Fetch up to a specified number of results (max: 50) 	| `limit=25`             	|
| categories     	| List of Integers - *Optional* 	| Filter the response by categories ids               	| `categories=1,2,3`     	|
| sub_categories 	| List of Integers - *Optional* 	| Filter the response by sub categories ids           	| `sub_categories=1,2,3` 	|
| versions 	        | List of Floats - *Optional*  	    | Filter response by specifics versions          	    | `versions=1.0,13.1` 	    |

#### Example
```http
GET https://api.emojisworld.fr/v1/random?&categories=7,8,6&sub_categories=61,66,63&versions=0.6,13.0&limit=2
```

#### Sample Response
```json
{
  "totals": 2,
  "results": [
    {
      "id": 1254,
      "name": "clutch bag",
      "emoji": "👝",
      "unicode": "1F45D",
      "version": "0.6",
      "category": {
        "id": 8,
        "name": "Objects"
      },
      "sub_category": {
        "id": 66,
        "name": "clothing"
      },
      "children": [

      ]
    },
    {
      "id": 3588,
      "name": "military helmet",
      "emoji": "🪖",
      "unicode": "1FA96",
      "version": "13.0",
      "category": {
        "id": 8,
        "name": "Objects"
      },
      "sub_category": {
        "id": 66,
        "name": "clothing"
      },
      "children": [

      ]
    }
  ]
}
```

### Popular emojis
```http
GET https://api.emojisworld.fr/v1/popular
```

#### Query String Options

| Query Strings  	| Type             	                | Description                                         	| Example                	|
|----------------	|--------------------------------   |-----------------------------------------------------	|------------------------	|
| limit          	| Integer - *Optional*          	| Fetch up to a specified number of results (max: 50) 	| `limit=25`             	|
| categories     	| List of Integers - *Optional* 	| Filter the response by categories ids               	| `categories=1,2,3`     	|
| sub_categories 	| List of Integers - *Optional* 	| Filter the response by sub categories ids           	| `sub_categories=1,2,3` 	|
| versions 	        | List of Floats - *Optional*  	    | Filter response by specifics versions          	    | `versions=1.0,13.1` 	    |

#### Example
```http
GET https://api.emojisworld.fr/v1/popular?&categories=7,8,6&sub_categories=61,66,63&versions=0.6,13.0&limit=2
```

#### Sample Response
```json
{
  "totals": 2,
  "results": [
    {
      "id": 1253,
      "name": "handbag",
      "emoji": "👜",
      "unicode": "1F45C",
      "version": "0.6",
      "count": 46,
      "category": {
        "id": 8,
        "name": "Objects"
      },
      "sub_category": {
        "id": 66,
        "name": "clothing"
      },
      "children": [

      ]
    },
    {
      "id": 1252,
      "name": "purse",
      "emoji": "👛",
      "unicode": "1F45B",
      "version": "0.6",
      "count": 45,
      "category": {
        "id": 8,
        "name": "Objects"
      },
      "sub_category": {
        "id": 66,
        "name": "clothing"
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
   "totals":10,
   "results":[  
      {  
         "id":1,
         "name":"Smileys & Emotion",
         "emojis_count":163,
         "sub_categories":[
           {
             "id": 1,
             "name": "face-smiling",
             "emojis_count": 14
           },
           {
             "id": 2,
             "name": "face-affection",
             "emojis_count": 9
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
  "id": 1,
  "name": "grinning face",
  "emoji": "😀",
  "unicode": "1F600",
  "version": "1.0",
  "category": {
    "id": 1,
    "name": "Smileys & Emotion"
  },
  "sub_category": {
    "id": 1,
    "name": "face-smiling"
  },
  "children": [

  ],
  "parent": null
}
```

## Technical detail

API Rate Limiting : **500 REQUESTS / DAY / IP**.

| Header                | Description                                                                | Example |
|-----------------------|----------------------------------------------------------------------------| ------------- |
| X-Ratelimit-Limit     | The maximum number of request you-re permitted to make per period of 1 day | 500 |
| X-Ratelimit-Remaining | Your current number of request                                             | 100 |
| X-Ratelimit-Reset     | Date in timestamp at which the rate limit resets                           | 1743518607 |

* API is using PHP with Laravel 12 framework
* All emojis data are stored in a MySQL and Typesense databases

## Contributing

**I search contributors for help me to complete and correct keywords for each emoji. This will allow for a better and more relevant search.**

We encourage you to contribute to Emojis World !! Please check out the [Contributing to Emojis World guide](https://github.com/abourtnik/emojis-world/blob/master/contributing.md) for guidelines about how to proceed. Join us!

Trying to report a possible security vulnerability in Emojis World ? Consider using email : 
**contact@antonbourtnik.fr** with clear description of security vulnerability.

## License
Emojis World is made available under the [MIT License](http://www.opensource.org/licenses/mit-license.php).

## Credits
Emojis World is created and maintained by [Anton Bourtnik](https://github.com/abourtnik)

## Support Project
[Make a PayPal Donation](https://www.paypal.com/donate/?hosted_button_id=J4ZPUYZ5EGGS8)

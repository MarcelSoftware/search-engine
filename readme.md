# Search Engine
This package is a simple tool to find the best match of a string in a list of words

## Installation
```composer require sowas/search-engine```

## Usage 
### Simple search of words
```php
use Sowas\SearchEngine;

$data = ["ABC", "CDE", "EFG", "GHI", "IJKA"];
$searchEngine = new SearchEngine($data);
$result = $searchEngine->search("ABC"); // returns ["ABC", "CDE", "IJKA", "EFG", "GHI"];
```

### Search in Objects
When you want to search for the best matching object you can define the attribute in the constructor of the engine
```php
use Sowas\SearchEngine;

$data = [...]; //Array of objects
$searchEngine = new SearchEngine($data, 'attribute');
$result = $searchEngine->search("ABC"); // returns Array of objects ordered by best match;
```


### Simple search of german words
When you want to find german words you can use the Search Engine without loading any external data
```php
use Sowas\SearchEngine;

$searchEngine = new SearchEngine();
$result = $searchEngine->search("Pferd", 5); // returns ["Pferd", "Pferde", "Pferdes", "Pferden", "Per"]
```

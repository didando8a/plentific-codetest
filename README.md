# Plentific

Library to provide a service for creating and retrieving users via a remote API

## How to install

Skipped due to the specifications of the code test but it could be installed either from github or pushing the package to packagist



## Usage

```php
...
use Didando8a\Plentific\DTO\Exception\UserDomainException;
use Didando8a\Plentific\Repository\UserApiImpl;
use Didando8a\Plentific\Service\UserReqrestService;
use GuzzleHttp\Client;
...

//implementation of https://reqres.in/
// other apis or repositories can be added by implementing the interfaces:
// Didando8a\Plentific\Repository\UserRepositoryInterface and
// Didando8a\Plentific\Service\UserRepositoryInterface 

$reqrestService = new UserReqrestService(    
    new UserApiImpl(
        new Client()
    )
);


// find a user     
try {
    $user = $reqrestService->find(2);
    
    /**    
    $user = [
      ["id"]=> 2
      ["email"]=> "janet.weaver@reqres.in"
      ["first_name"] => "Janet"
      ["last_name"] => "Weaver"
      ["avatar"] => "https://reqres.in/img/faces/2-image.jpg"
    ];
     */ 
} catch (UserDomainException $e) {
    //handle exception
}


// create a user     
try {
    $id = $reqrestService->create('Michael', 'Chairman');
    
    // $id will store the id of the new user
    
} catch (UserDomainException $e) {
    //handle exception
}

// list users     
try {
    $users = $reqrestService->list(2);
    
    /**    
    $users = [
            "page" => 1, 
            "per_page" => 2, 
            "total" => 12, 
            "total_pages" => 6, 
            "data" => [
                [
                    "id"=> 1, 
                    "email" => "george.bluth@reqres.in", 
                    "first_name" => "George", 
                    "last_name" => "Bluth", 
                    "avatar" => "https://reqres.in/img/faces/1-image.jpg",
                ],
                [
                    "id" => 2,
                    "email" => "janet.weaver@reqres.in",
                    "first_name"=> "Janet", 
                    "last_name"=> "Weaver", 
                    "avatar"=> "https://reqres.in/img/faces/2-image.jpg",
                ]
            ]
        ];
     */ 
} catch (UserDomainException $e) {
    //handle exception
}


```

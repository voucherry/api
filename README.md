#Voucherry API V1


## General

All API access is over HTTPS and starts with https://voucherry.com.com/api/v1/

### Authentication

You can use HTTP Basic Auth to authenticate as a Voucherry user. If you want to pass your API token instead, add auth\_token to submitted arguments. 

*Note that all requests that need authentication should include the Authentication header or auth\_token parameter in the query string. Unauthenticated requests will return 401 Unauthorized to prevent any sort of private information leakage or api misuse.*


### Error Handling

If the request is successful the http status code will be 200 and a JSON representation of the resource will be provided.

If the request is unsuccessful the http status code will be set depending on the error that was triggered and a JSON representation of the error will be provided.


### Conventions

The arguments of an API call can be passed using the following content types:
  
  * __application/x-www-form-urlencoded__ -- the arguments must be passed as serialized form fields.
  * __application/json__ -- the arguments must be encoded as a JSON object and sent in the body of the request ( applies only for POST and PUT requests ).
  * __multipart/form-data__ -- the arguments must be passed as valid multipart form data.



## API Calls
### Send Cherries to an email address.



__Request Method__: POST

__URL__: /api/v1/cherries_transfers

__Arguments__:

<table>
    <tr>
        <th>email_address</th>
        <td>A valid email address</td>
    </tr>
    <tr>
        <th>cherries_amount</th>
        <td>An integer grater than 0</td>
    </tr>
    <tr>
        <th>email_subject</th>
        <td>string minimum 6 chars maximum 128 chars</td>
    </tr>
    <tr>
        <th>email_body</th>
        <td>string minimum 6 chars maximum 65000 chars</td>
    </tr>

    <tr>
        <th>metadata(optional)</th>
        <td>An arbitrary hash, associative array or string</td>
    </tr>
    
</table>

*The __email address__ doesn't need to have an account associated on voucherry.com platform, an email will be sent to the given email address that will in your behalf.*


__Returns__ a JSON representation of the resource upon success and the status code is set to 200

    {
      "id": <transfer uniq id>,
      "cherries_amount": <integer>,
      "status": "waiting_for_confirmation",
      "created_at": "<date-time>",
      "invite_id": <null if no associated account is found string otherwise>,
      "url": <url that identifies the resource>,
      "metadata": <json encoded object provided on create or null if none was given>
    }

__Returns__ a JSON representation of the errors upon failure and the status code is set to 409

    {
        "errors" : <array of strings that are describing the error>
    }




### Send Cherries to an invite id.

__Request Method__: POST

__URL__: /api/v1/cherries_transfers

__Arguments__:

<table>
    <tr>
        <th>invite_id</th>
        <td>a valid voucherry invite id.</td>
    </tr>
    <tr>
        <th>cherries_amount</th>
        <td>An integer grater than 0</td>
    </tr>
    <tr>
        <th>email_subject</th>
        <td>string minimum 6 chars maximum 128 chars</td>
    </tr>
    <tr>
        <th>email_body</th>
        <td>string minimum 6 chars maximum 65000 chars</td>
    </tr>

    <tr>
        <th>metadata(optional)</th>
        <td>An arbitrary hash, associative array or string</td>
    </tr>
    
</table>

*The invite id needs to be a valid voucherry.com invite id.*

__Returns__ a JSON representation of the resource upon success and the status code is set to 200

    {
      "id": <transfer uniq id>,
      "cherries_amount": <integer>,
      "status": "waiting_for_confirmation",
      "created_at": "<date-time>",
      "invite_id": <null if no associated account is found string otherwise>,
      "url": <url that identifies the resource>,
      "metadata": <json encoded object provided on create or null if none was given>
    }

__Returns__ a JSON representation of the errors upon failure and the status code is set to 409

    {
        "errors" : <array of strings that are describing the error>
    }

### Creating a cherries transfer request using an email address.

__Important__: The cherries will not be transferred right away you need to issue a confirmation call so that the actual transfer really happens.

__Request Method__: POST

__URL__: /api/v1/cherries_requests

__Arguments__:

<table>
    <tr>
        <th>email_address</th>
        <td>an email address that is associated with a voucherry account.</td>
    </tr>
    <tr>
        <th>cherries_amount</th>
        <td>An integer grater than 0</td>
    </tr>
    <tr>
        <th>title</th>
        <td>string minimum 6 chars maximum 128 chars</td>
    </tr>
    <tr>
        <th>description</th>
        <td>string minimum 6 chars maximum 65000 chars</td>
    </tr>

    <tr>
        <th>metadata (optional)</th>
        <td>An arbitrary hash, associative array or string</td>
    </tr>

</table>

*The __email address__ needs to be associated with a valid voucherry.com account.*

__Returns__ a JSON representation of the resource upon success and the status code is set to 200

    {
      "id": <request uniq id>,
      "cherries_amount": <integer>,
      "status": "waiting_for_confirmation",
      "created_at": "<date-time>",
      "invite_id": <null if no associated account is found string otherwise>,
      "url": <url that identifies the resource>,
      "metadata": <json encoded object provided on create or null if none was given>
    }

__Returns__ a JSON representation of the errors upon failure and the status code is set to 409

    {
        "errors" : <array of strings that are describing the error>
    }





### Creating a cherries transfer request using an invite id.

__Important__: The cherries will not be transferred right away you need to issue a confirmation call so that the actual transfer really happens.

__Request Method__: POST

__URL__: /api/v1/cherries_requests

__Arguments__:

<table>
    <tr>
        <th>invite_id</th>
        <td>a valid voucherry invite id.</td>
    </tr>
    <tr>
        <th>cherries_amount</th>
        <td>An integer grater than 0</td>
    </tr>
    <tr>
        <th>title</th>
        <td>string minimum 6 chars maximum 128 chars</td>
    </tr>
    <tr>
        <th>description</th>
        <td>string minimum 6 chars maximum 65000 chars</td>
    </tr>

    <tr>
        <th>metadata (optional)</th>
        <td>An arbitrary hash, associative array or string</td>
    </tr>

</table>

*The __invite_id__ needs to be a valid voucherry invite id.*

__Returns__ a JSON representation of the resource upon success and the status code is set to 200

    {
      "id": <request uniq id>,
      "cherries_amount": <integer>,
      "status": "waiting_for_confirmation",
      "created_at": "<date-time>",
      "invite_id": <null if no associated account is found string otherwise>,
      "url": <url that identifies the resource>,
      "metadata": <json encoded object provided on create or null if none was given>
    }

__Returns__ a JSON representation of the errors upon failure and the status code is set to 409

    {
        "errors" : <array of strings that are describing the error>
    }


### Confirming a transfer request

__Request Method__: GET

__URL__: /api/v1/cherries_requests/:id/confirm

__Arguments__:

<table>
    <tr>
        <th>:id</th>
        <td>a valid cherries request id obtain via the POST method.</td>
    </tr>

</table>

*Note: if the request is already confirmed the resource update is silently discarded.*

__Returns__ a JSON representation of the resource upon success and the status code is set to 200

    {
      "id": <request uniq id>,
      "cherries_amount": <integer>,
      "status": "waiting_for_confirmation",
      "created_at": "<date-time>",
      "invite_id": <null if no associated account is found string otherwise>,
      "url": <url that identifies the resource>,
      "metadata": <json encoded object provided on create or null if none was given>
    }

__Returns__ a JSON representation of the errors upon failure and the status code is set to 409

    {
        "errors" : <array of strings that are describing the error>
    }

# API Wrappers


* php-client  Voucherry API php client
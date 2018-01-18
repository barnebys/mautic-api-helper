### Mautic API Helper

Requires the [Mautic Simple Mail](https://github.com/barnebys/MauticSimpleEmailBundle) plugin to be installed.

#### With basic auth

```
BarnebysMautic\Auth::initializeHttpBasic('username', 'password');
BarnebysMautic\Api::setBaseUrl('https://my.mautic.domain/api');
```

### With oauth

```
BarnebysMautic\Auth::initializeOAuth2
```

### Fetch a contact id by email
```
try {
    $data = BarnebysMautic\Api::getContactIdByMail('some@email.com');
} catch (BarnebysMautic\Exception\ContactNotFoundException $exception) {
    // Handle error
}
```

### Handling Contacts

##### Creating a contact

```
BarnebysMautic\Api::createContact($email, array $fields = [);
```

##### Updating a contact

Updating a contact will do a PATCH and only update specified fields in the array.

```
BarnebysMautic\Api::updateContact($email, array $fields = [);
```


### Sending emails

When sending emails you can with ease use `sendToContact` and just set the email and a templateId.
If you need to pass on some custom fields to be used in Mautic those can set as a key => value array for parameter 3.
When sending values contain HTML and to disable Mautic HTML escaper set the 4th parameter to true.
  
##### Sending a email with custom fields 

```
$tokens = [
    'custom_content' => 'This will value will be available in mautic as {custom_content}'
];

sendToContact($mail, $templateId, $tokens)
```

##### Sending a email with html content 

```
$tokens = [
    'html_content' => '<span>This html content will not be escpaed</span>'
];

sendToContact($mail, $templateId, $tokens, true)
```

### Other available methods
```
getContactIdByMail($mail)
sendToLead($mail, $templateId, array $tokens = [], $html = false)
sendToContact($mail, $templateId, array $tokens = [], $html = false)
```
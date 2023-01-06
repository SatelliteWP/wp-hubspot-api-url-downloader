# Hubspot API URL Downloader for WP All import

Call a Hubspot API URL for WP All import.

By default, WP All import does not make it simple to add headers to a URL call. Since October 2022, the API key to get results from Hubspot is not passed in the URL. Therefore, it needs a way to send the API key differently.

This plugin solves this specific issue.


## How to use ?

In the URL field, simply wrap your URL by calling our `hubspot_api_url()` function.

Previously, your URL looked like this:

    https://api.hubapi.com/cms/v3/blogs/posts?hapikey=XXXXX-YYYY-ZZZZ&limit=1000&state=PUBLISHED&tagId__in=123,456
    
With this plugin, simply :

1- Remove the old `hapikey` parameter from the URL so it becomes something like this:

    https://api.hubapi.com/cms/v3/blogs/posts?limit=1000&state=PUBLISHED&tagId__in=123,456
    
    
2- [Generate a private application key and set the right permissions](https://developers.hubspot.com/docs/api/private-apps) in your Hubspot account.

3- Wrap the new URL with our function and add your newly create API key as a parameter like this:

    [hubspot_api_url("https://api.hubapi.com/cms/v3/blogs/posts?limit=1000&state=PUBLISHED&tagId__in=123,456","pat-na1-xxxxxxx-xxxx-xxxx-xxxx-xxxxx")]
    

**Caution: Make sure there is no space between your parameters next to the comma. Otherwise, it won't work. That is a parsing limitation from WP All import.**

*Note:* In our example, the API key is `pat-na1-xxxxxxx-xxxx-xxxx-xxxx-xxxxx`.

## Credits

This code was created and is maintained by [SatelliteWP](https://www.satellitewp.com/en), a maintenance service specialized in cybersecurity and performance for WordPress websites.

It is based on [this gist](https://gist.github.com/trey8611/6fbf6d36b5b86068d86253ccf934eb55) by [Trey](https://github.com/trey8611).

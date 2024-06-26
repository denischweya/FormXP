Use the shortcode **[custom_form]** to display the input form.

Use the shortcode **[custom_data_display]** to display the data table with search functionality.

# To use these new API endpoints:

## To retrieve data:
Send a GET request to http://your-site.com/wp-json/formxp/v1/data

You can add a search parameter like this: http://your-site.com/wp-json/custom-plugin/v1/data?search=keyword

## To insert data:
Send a POST request to http://your-site.com/wp-json/formxp/v1/data
with a JSON body like this:
```json
jsonCopy{
  "name": "John Doe",
  "email": "john@example.com",
  "message": "Hello, World!"
}
```

Remember to replace http://your-site.com with your actual WordPress site URL.

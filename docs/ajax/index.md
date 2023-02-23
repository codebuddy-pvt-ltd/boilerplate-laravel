# Ajax Support

You will find below mentioned files related to this module -

```bash
app/
    /Services
        /Http
            /Response
                /APIResponse.php
public/
    /assets
        /js
            /action-confirmation.js
            /ajax.js
            /process-form.js
            /toast.js
            /util.js
```

## APIResponse.php

This file is mainly responsible to send API responses back to the client.

Example implementation snippet.

```bash
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Http\Response\APIResponse;
use Illuminate\Http\Request;

class OrderItemStatusController extends Controller
{
    public function store(Request $request)
    {
        // your code here...

        return APIResponse::build()
            ->status('success')
            ->statusCode(201)
            ->message('Item created successfully!')
            ->send();
    }
}

```

#### `public static build(): self`

Creates an instance of the `APIResponse` class and stores in a private variable.

#### `public static function send(): JsonResponse`

Sends the json response back to the client in a proper format.

#### `public static function statusCode(string $code): self`

Sets the status code for the response. Eg:

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Item created successfully!')
    ->send();
```

#### `public static function headers(array $headers): self`

Sets response headers.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->headers([
        'Content-Type' => 'text/html; charset=utf-8',
    ])
    ->message('Item created successfully!')
    ->send();
```

#### `public static function status(string $status): self`

Sets the status property in the response. This will show either green or red toast for `success` and `error` values respectively. Valid statuses are: `success`, `error`

```bash
return APIResponse::build()
    ->status('success') // valid values: 'status' | 'error'
    ->statusCode(201)
    ->message('Item created successfully!')
    ->send();
```

#### `public static function message(string $message): self`

Sets the message which will be shown using toast.js plugin.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Item created successfully!')
    ->send();
```

#### `public static function data($data): self`

This methods sets the data property of the response. You can use this data to work with response.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Item created successfully!')
    ->data([
        'user_id' => auth()->user()->id,
    ])
    ->send();
```

#### `public static function images(array $images): self`

Sometimes you might want to display the image in file upload preview via ajax. Ex. while working with modals you want the modal form to be populated with form data. This method will add input name and image path in a key-value pair. The js script in process-form.js will show the preview of the image in the form.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Item created successfully!')
    ->images([
        'display_picture' => auth()->user()->display_picture,
    ])
    ->send();
```

#### `public static function redirectTo(string $url): self`

If you want the user to be redirected to specific url after the doing some ajax operation, you can pass that url in this method.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(200)
    ->redirectUrl(route('admin.categories.index'))
    ->send();
```

#### `public static function messageDisplayDuration(int $microSeconds): self`

To control the number of seconds a message toast should appear in the browser, you can use this method. This method is also used to delay the redirect operation so that user can see the message toast for sometime.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Item has been created successfully!')
    ->messageDisplayDuration(3000) // the toast will appear for 3 secs and then the user will be redirected to the below url
    ->redirectUrl(route('admin.categories.index'))
    ->send();
```

#### `public static function clearForm(bool $clear = true): self`

Clear the form after doing some operation.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Item has been created successfully!')
    ->clearForm()
    ->send();
```

#### `public static function hideModal(string $modalId): self`

Use this method to hide modal. Use Case: When you submit a form via modal you want to close the modal after the item has been created.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Category has been created successfully!')
    ->hideModal('#category-modal')
    ->send();
```

#### `public static function showModal(string $modalId): self`

Use this method to show modal. Use Case: When you want to edit something in modal, you want fetch the data first, populate the form then open modal with pre-filled values.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(200)
    ->data([
        'user' => auth()->user()
    ])
    ->showModal('#category-modal')
    ->send();
```

#### `public static function hideSidebar(string $sidebarId): self`

If you app has sidebar component. Use this method to hide a sidebar. It will remove the `active` class from the sidebar component.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(200)
    ->hideSidebar('#category-sidebar')
    ->send();
```

#### `public static function openSidebar(string $sidebarId): self`

If you app has sidebar component. Use this method to open a sidebar. It will remove the `active` class from the sidebar component.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(200)
    ->openSidebar('#category-sidebar')
    ->send();
```

#### `public static function hideSection(string $sectionId): self`

If you want hide a html section, you can pass the id of the element to hide from view.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(200)
    ->hideSection('#category-section')
    ->send();
```

#### `public static function showSection(string $sectionId): self`

If you want show a html section, you can pass the id of the element to make the element visible.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(200)
    ->showSection('#category-section')
    ->send();
```

#### `public static function refresh(): self`

Reloads the page. You also use this with `messageDisplayDuration` to delay the reload.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(200)
    ->refresh()
    ->send();
```

#### `public static function html(string $id, string $pathToView): self`

If you want to update the html content of an element, you can use this method.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(200)
    ->html([
        '#sidebar-content' => view('admin.categories.partials.sidebar-content')
    ])
    ->send();
```

#### `public static function refreshDataTable(string $tableId): self`

Many a times, while working with modal forms, you don't want to reload the whole page to show updated data in the datatable. To solve this problem you can pass the datatable id in this method to refresh a datatable.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Item added successfully!')
    ->refreshDataTable('#user-datatable')
    ->send();
```

#### `public static function dispatchBrowserEvent(string $eventName, $data = null): self`

Most of the common functionality related to ajax request has been covered out of the box but if you still want to do certain things based on your response data, you can use this method to emit js custom events and listen to this events to implement a custom functionality.

```bash
return APIResponse::build()
    ->status('success')
    ->statusCode(201)
    ->message('Item added to the cart successfully!')
    ->dispatchBrowserEvent('update_cart_count', auth()->user()->cart_count)
    ->dispatchBrowserEvent('mark_added_in_the_cart')
    ->send();
```

And add this in your js files to listen to these event.

```bash
document.addEventListener('update_cart_count', (event) => {
    const count = event.detail.data;

    // your code here...
})

document.addEventListener('mark_added_in_the_cart', (event) => {
    // your code here...
})
```

#### `public static function errors(array $errors): self`

If you want send custom errors to the client, you can pass them in the method.

```bash
return APIResponse::build()
    ->status('error')
    ->statusCode(400)
    ->errors([
        ['user_id' => 'Not a valid id!']
    ])
    ->send();
```

#### `public static function sendInternalServerError(\Throwable $th, array $events = []): JsonResponse`

If you want to send an internal server error manually, use this method. When an unhandled exception occurs, `Handler.php` file will take care of it using this method.
Except `staging` and `production` environment, you will get a error message and trace so that it is easier to debug the issue.

```bash
return APIResponse::sendInternalServerError($th, [
    [
        'name' => 'custom_event_name_1',
        'data' => 'custom data 1',
    ],
    [
        'name' => 'custom_event_name_2',
        'data' => 'custom data 2',
    ],
]);
```

<br/>

## ajax.js

This file is mainly responsible to send ajax request to the server. It will dispatch custom js events to listen to. You can listen to these custom events to bind your custom functionalities. These events can be listened using below mentioned methods.

1. `beforeSend((event))`

```bash
beforeSend((event) => {
    // do something here before ajax request is fired
})
```

2. `onSuccess((event))`

```bash
onSuccess((event) => {
    const data = event.data.res;
    // do something here if ajax request received a success response
})
```

3. `onError((event))`

```bash
onError((event) => {
    const data = event.data.res;
    // do something here if ajax request received an error response
})
```

4. `onComplete((event))`

```bash
onComplete((event) => {
    const data = event.data.res;
    // do something here if ajax request is completed
})
```

Example code snippet

```bash
<script>
$(document).ready(function () {
    $('.button').click(function (e) {
        e.preventDefault();

        const url = $(this).data('url');
        const method = $(this).data('method');

        new Ajax(url, method)
            .beforeSend((event) => {
                $('.loader').show();
            })
            .onSuccess((event) => {
                const data = event.detail.res;

                // your code here...
            })
            .onError((event) => {
                // your code here
            })
            .onComplete((event) => {
                $('.loader').hide();
            })
            .send();
    });
});
</script>
```

## process-form.js

This file is primarily responsible to handle form submission using ajax. Add `ajax-form` class to your form to send the form data via ajax. You can check out this file to see how form request is handled out of the box. This file uses `ajax.js` file's functionality to send ajax form request and handle response.

```bash
<form action="{{ route('admin.categories.store') }}" class="ajax-form" type="POST">
   <div class="row">
        <div class="col-md-12 form-group">
            <label for="name">Name</label>
            <input id="name" type="text" class="form-control" name="name" value="">
        </div>
        <div class="col-md-12 form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
     </div>
</form>
```

## action-confirmation.js

Many a times, while performing an action, you want user to see a confirmation dialog to confirm operation. Eg. While updating a status, going to some external link etc. This file handles functionality related to it. Add `action-confirmation` class to the element and add `data-url` property to the url you want to send the ajax request to upon confirmation.
You can use `data-type` property to specify what kind of request methods('get', 'post', 'delete') you want to use, by default value is 'delete'.
Available `data-` properties -

`data-title`
`data-text`
`data-icon`
`data-type`
`data-payload`
`data-confirm-btn-text`
`data-confirm-btn-color`
`data-cancel-btn-text`
`data-cancel-btn-color`

```bash
<a href="#" class="action-confirmation" data-url="{{ $deleteUrl }}">
    <i fa="fa fa-trash"></i> Delete
</a>
```

### util.js

This script contains some common utility functions and implementations that is generally used globally.

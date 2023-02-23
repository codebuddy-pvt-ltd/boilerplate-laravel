[![N|Solid](https://codebuddy.co/assets/img/Logo.svg)](https://codebuddy.co/)

# Introduction

If you are starting fresh new laravel project, then boilerplates can be the best option for you to get started. It gives you a full laravel project with everything installed and published.

## Installation

It comes with easy steps to get boilerplate working.

Clone the project

```bash
  git clone https://github.com/codebuddy-pvt-ltd/boilerplate-laravel
```

Go to the project directory

```bash
  cd boilerplate-laravel
```

Create .ENV file

```bash
  cp .env.example .env
```

Update DB credentials

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel8
DB_USERNAME=root
DB_PASSWORD=
```

Install dependencies

```bash
  composer install
```

Generate application key to run

```bash
  php artisan key:generate
```

Run migration

```bash
  php artisan migrate
```

Once everything is installed, you are ready to go with generator.

Open BASE_URL/generator_builder URL on your server or whatever customized routes you have placed to craete the CRUD from GUI.

<br/>
<br/>
<br/>

## Ajax Support

All of the forms will be submitted via ajax and will be handled by our custom `app/Services/Http/Response/APIResponse.php` class.
Follow link to read more about it - [Ajax Support](/docs/ajax/index.md)

# Coding Guidelines

#### _Follow Laravel naming conventions_

> Follow PSR standards.
> Also, follow naming conventions accepted by Laravel community:

| WHAT                             | HOW                                        | GOOD                                    | BAD                                                  |
| -------------------------------- | ------------------------------------------ | --------------------------------------- | ---------------------------------------------------- |
| Controller                       | singular                                   | ArticleController                       | ~~ArticlesController~~                               |
| Route                            | plural                                     | articles/1                              | ~~article/1~~                                        |
| Named route                      | snake_case with dot notation               | users.show                              | ~~users.show-active, show-active-users~~             |
| Model                            | singular                                   | User                                    | ~~Users~~                                            |
| hasOne or belongsTo relationship | singular                                   | articleComment                          | ~~articleComments, article_comment~~                 |
| All other relationships          | plural                                     | articleComments                         | ~~articleComment, article_comments~~                 |
| Table                            | plural                                     | article_comments                        | ~~article_comment, articleComments~~                 |
| Pivot table                      | singular model names in alphabetical order | article_user                            | ~~user_article, articles_users~~                     |
| Table column                     | snake_case without model name              | meta_title                              | ~~MetaTitle; article_meta_title~~                    |
| Foreign key                      | singular model name with \_id suffix       | article_id                              | ~~ArticleId, id_article, articles_id~~               |
| Primary key                      | -                                          | id                                      | ~~custom_id ~~                                       |
| Migration                        | -                                          | 2017_01_01_000000_create_articles_table | ~~2017_01_01_000000_articles~~                       |
| Method                           | camelCase                                  | getAll                                  | ~~get_all~~                                          |
| Function                         | snake_case                                 | abort_if                                | ~~abortIf~~                                          |
| Method in resource controller    | more infos: table                          | store                                   | ~~saveArticle~~                                      |
| Method in test class             | camelCase                                  | testGuestCannotSeeArticle               | ~~test_guest_cannot_see_article~~                    |
| Model property                   | snake_case                                 | $model->model_property                  | ~~$model->modelProperty~~                            |
| Variable                         | camelCase                                  | $anyOtherVariable                       | ~~$any_other_variable ~~                             |
| Collection                       | descriptive, plural                        | $activeUsers = User::active()->get()    | ~~$active, $data~~                                   |
| Object                           | descriptive, singular                      | $activeUser = User::active()->first()   | ~~$users, $obj~~                                     |
| Config and language files index  | snake_case                                 | articles_enabled                        | ~~ArticlesEnabled; articles-enabled ~~               |
| View                             | kebab-case                                 | show-filtered.blade.php                 | ~~showFiltered.blade.php, show_filtered.blade.php ~~ |
| Config                           | kebab-case                                 | google-calendar.php                     | ~~googleCalendar.php, google_calendar.php ~~         |
| Contract (interface)             | adjective or noun                          | Authenticatable                         | ~~AuthenticationInterface, IAuthentication ~~        |
| Trait                            | adjective                                  | Notifiable                              | ~~NotificationTrait~~                                |

### _Use shorter and more readable syntax where possible_

#### Bad:

```
$request->session()->get('cart');
$request->input('name');
```

#### Good:

```
session('cart');
$request->name;
```

More examples:

| GOOD                                                                 | BAD                                              |
| -------------------------------------------------------------------- | ------------------------------------------------ |
| Session::get('cart')                                                 | session('cart')                                  |
| $request->session()->get('cart')                                     | session('cart')                                  |
| Session::put('cart', $data)                                          | session(['cart' => $data])                       |
| $request->input('name'), Request::get('name')                        | $request->name, request('name')                  |
| return Redirect::back()                                              | return back()                                    |
| is_null($object->relation) ? $object->relation->id : null }          | optional($object->relation)->id                  |
| return view('index')->with('title', $title)->with('client', $client) | return view('index', compact('title', 'client')) |
| $request->has('value') ? $request->value : 'default';                | $request->get('value', 'default')                |
| Carbon::now(), Carbon::today()                                       | now(), today()                                   |
| App::make('Class')                                                   | app('Class')                                     |
| ->where('column', '=', 1)                                            | ->where('column', 1)                             |
| ->orderBy('created_at', 'desc')                                      | ->latest()                                       |
| ->orderBy('age', 'desc')                                             | ->latest('age')                                  |
| ->orderBy('created_at', 'asc')                                       | ->oldest()                                       |
| ->select('id', 'name')->get()                                        | ->get(['id', 'name'])                            |
| ->first()->name                                                      | ->value('name')                                  |

### _Single responsibility principle_

> A class and a method should have only one responsibility.

#### Bad:

```
public function getFullNameAttribute() {
    if (auth()->user() && auth()->user()->hasRole('client') && auth()->user()->isVerified()) {
        return 'Mr. ' . $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    } else {
        return $this->first_name[0] . '. ' . $this->last_name;
    }
}
```

#### Good:

```
public function getFullNameAttribute() {
    return $this->isVerifiedClient() ? $this->getFullNameLong() : $this->getFullNameShort();
}

public function isVerifiedClient() {
    return auth()->user() && auth()->user()->hasRole('client') && auth()->user()->isVerified();
}

public function getFullNameLong() {
    return 'Mr. ' . $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
}

public function getFullNameShort() {
    return $this->first_name[0] . '. ' . $this->last_name;
}
```

### _Fat models, skinny controllers_

> Put all DB related logic into Eloquent models or into Repository classes if you’re using Query Builder or raw SQL queries.

#### Bad:

```
public function index() {
    $clients = Client::verified()
        ->with(['orders' => function ($q) {
            $q->where('created_at', '>', Carbon::today()->subWeek());
        }])
        ->get();
        return view('index', ['clients' => $clients]);
    }
```

#### Good:

```
public function index() {
    return view('index', ['clients' => $this->client->getWithNewOrders()]);
}

class Client extends Model {
    public function getWithNewOrders() {
        return $this->verified()
            ->with(['orders' => function ($q) {
                $q->where('created_at', '>', Carbon::today()->subWeek());
            }])
            ->get();
    }
}
```

### _Validation_

> Move validation from controllers to Request classes.

#### Bad:

```
public function store(Request $request) {
    $request->validate([
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
        'publish_at' => 'nullable|date',
    ]);
        ....
}
```

#### Good:

```
public function store(PostRequest $request) {
    ....
}

class PostRequest extends Request {
    public function rules() {
        return [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
            'publish_at' => 'nullable|date',
        ];
    }
}
```

### _Business logic should be in service class_

> A controller must have only one responsibility, so move business logic from controllers to service classes.

#### Bad:

```
public function store(Request $request) {
    if ($request->hasFile('image')) {
        $request->file('image')->move(public_path('images') . 'temp');
    }

    ....
}
```

#### Good:

```
public function store(Request $request) {
    $this->articleService->handleUploadedImage($request->file('image'));
    ....
}

class ArticleService {
    public function handleUploadedImage($image) {
        if (!is_null($image)) {
            $image->move(public_path('images') . 'temp');
        }
    }
}
```

### _Don’t repeat yourself (DRY)_

> Reuse code when you can. SRP is helping you to avoid duplication. Also, reuse Blade templates, use Eloquent scopes etc.

#### Bad:

```
public function getActive() {
    return $this->where('verified', 1)->whereNotNull('deleted_at')->get();
}

public function getArticles() {
    return $this->whereHas('user', function ($q) {
        $q->where('verified', 1)->whereNotNull('deleted_at');
    })->get();
}
```

#### Good:

```
public function scopeActive($q) {
    return $q->where('verified', 1)->whereNotNull('deleted_at');
}

public function getActive() {
    return $this->active()->get();
}

public function getArticles() {
    return $this->whereHas('user', function ($q) {
            $q->active();
        })->get();
}
```

### _Prefer to use Eloquent over using Query Builder and raw SQL queries. Prefer collections over arrays_

> Eloquent allows you to write readable and maintainable code. Also, Eloquent has great built-in tools like soft deletes, events, scopes etc.

#### Bad:

```
SELECT *
    FROM `articles`
    WHERE EXISTS (SELECT *
                  FROM `users`
                  WHERE `articles`.`user_id` = `users`.`id`
                  AND EXISTS (SELECT *
                              FROM `profiles`
                              WHERE `profiles`.`user_id` = `users`.`id`)
                  AND `users`.`deleted_at` IS NULL)
    AND `verified` = '1'
    AND `active` = '1'
    ORDER BY `created_at` DESC
```

#### Good:

```
Article::has('user.profile')->verified()->latest()->get();
```

### _Mass assignment_

#### Bad:

```
$article = new Article;
    $article->title = $request->title;
    $article->content = $request->content;
    $article->verified = $request->verified;
    // Add category to article
    $article->category_id = $category->id;
    $article->save();
```

#### Good:

```
$category->article()->create($request->all());
```

### _Do not execute queries in Blade templates and use eager loading (N + 1 problem)_

### Bad (for 100 users, 101 DB queries will be executed):

```
@foreach (User::all() as $user)

@endforeach
```

### Good (for 100 users, 2 DB queries will be executed):

```
$users = User::with('profile')->get();

...

@foreach ($users as $user)

@endforeach
```

### Comment your code, but prefer descriptive method and variable names over comments

#### Bad:

```
if (count((array) $builder->getQuery()->joins) > 0)
```

#### Better:

```
// Determine if there are any joins.
    if (count((array) $builder->getQuery()->joins) > 0)
```

#### Good:

```
if ($this->hasJoins())
```

### _Do not put CSS in Blade templates and do not put any HTML in PHP classes_

> use separate CSS files and stack in the blade

### _Use config and language files, constants instead of text in the code_

#### Bad:

```
public function isNormal() {
    return $article->type === 'normal';
}

return back()->with('message', 'Your article has been added!');
```

#### Good:

```
public function isNormal() {
    return $article->type === Article::TYPE_NORMAL;
}

return back()->with('message', __('app.article_added'));
```

### _Use standard Laravel tools accepted by community_

> Prefer to use built-in Laravel functionality and community packages instead of using 3rd party packages and tools. Any developer who will work with your app in the future will need to learn new tools. Also, chances to get help from the Laravel community are significantly lower when you’re using a 3rd party package or tool. Do not make your client pay for that.

| Task                      | Standard tools                                | 3rd party tools                                         |
| ------------------------- | --------------------------------------------- | ------------------------------------------------------- |
| Authorization             | Policies                                      | Entrust, Sentinel and other packages                    |
| Compiling assets          | Laravel Mix                                   | Grunt, Gulp, 3rd party packages                         |
| Development Environment   | Homestead                                     | Docker                                                  |
| Deployment                | Laravel Forge                                 | Deployer and other solutions                            |
| Unit testing              | PHPUnit, Mockery                              | Phpspec                                                 |
| Browser testing           | Laravel Dusk                                  | Codeception                                             |
| DB                        | Eloquent                                      | SQL, Doctrine                                           |
| Templates                 | Blade                                         | Twig                                                    |
| Working with data         | Laravel collections                           | Arrays                                                  |
| Form validation           | Request classes                               | 3rd party packages, validation in controller            |
| Authentication            | Built-in                                      | 3rd party packages, your own solution                   |
| API authentication        | Laravel Passport                              | 3rd party JWT and OAuth packages                        |
| Creating API              | Built-in                                      | Dingo API and similar packages                          |
| Working with DB structure | Migrations Working with DB structure directly |
| Localization              | Built-in                                      | 3rd party packages                                      |
| Realtime user interfaces  | Laravel Echo, Pusher                          | 3rd party packages and working with WebSockets directly |
| Generating testing data   | Seeder classes, Model Factories, Faker        | Creating testing data manually                          |
| Task scheduling           | Laravel Task Scheduler                        | Scripts and 3rd party packages                          |
| DB                        | MySQL, PostgreSQL, SQLite, SQL Server         | MongoDB                                                 |

### _Use IoC container or facades instead of new Class_

> new Class syntax creates tight coupling between classes and complicates testing. Use IoC container or facades instead.

#### Bad:

```
$user = new User;
    $user->create($request->all());
```

#### Good:

```
public function __construct(User $user) {
    $this->user = $user;
}

....

$this->user->create($request->all());
```

### _Do not get data from the ".env"-file directly_

> Pass the data to config files instead and then use the config() helper function to use the data in an application.

#### Bad:

```
$apiKey = env('API_KEY');
```

#### Good:

```
// config/api.php
'key' => env('API_KEY'),

// Use the data
$apiKey = config('api.key');
```

### Store dates in the standard format. Use accessors and mutators to modify date format

#### Bad:

```

```

#### Good:

```
// Model
protected $dates = ['ordered_at', 'created_at', 'updated_at']
public function getSomeDateAttribute($date) {
    return $date->format('m-d');
}

// View
```

### Other important practices

> these are some general practices which needs to be adhere

#### all variables must be camel case **$testVariable**

#### brace must start with the same line of the function

> public function xyz() {

#### must follow 4 spaces for indentation

#### autoload Helper file should not contain any DB interaction

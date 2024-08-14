<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="{{asset('favicon.ico')}}" type="image/x-icon" rel="shortcut icon" />
<title>{{$title ?? 'PAGE NOT FOUND'}}</title>
<meta name="keywords" content="{{$keywords ?? '' }}" />
<meta name="description" content="{{ $description ?? 'PAGE NOT FOUND' }}" />
<meta name="author" content="{{app('request')->getRequestUri()}}">
<meta name="robots" content="{{$robots ?? 'noindex,nofollow'}}" />
<link rel="canonical" href="{{$canonical ?? request()->fullUrl()}}" />


<meta property="og:image" content="{{$og_image ?? 'Error'}}" />
<meta property="og:url" content="{{$og_url ?? request()->fullUrl()}}">
<meta property="og:title" content="{{ $title ?? 'PAGE NOT FOUND' }}" />
<meta property="og:description" content="{{ $description ?? 'PAGE NOT FOUND' }}" />
<meta property="og:type" content="website" />
<meta property="og:locale" content="en_US" />
<meta property="og:site_name" content="" />
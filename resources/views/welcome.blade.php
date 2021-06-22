<!DOCTYPE html>
<html lang="">
<head>
  <title>Beta Fact</title>
  <link rel="icon" type="image/png" sizes="32x32" href="{{Request::root()}}/favicon.png">
  <link href="{{Request::root()}}/css/sf.min.css" rel="stylesheet">
  <link href="{{Request::root()}}/css/font-icon.css" rel="stylesheet">
  <link href="{{Request::root()}}/css/main.css" rel="stylesheet">
  <style>
    @font-face {
      font-family: element-icons;
      src: url(http://localhost/beta-fact/node_modules/element-ui/lib/theme-chalk/fonts/element-icons.woff) format("woff"), url(http://localhost/beta-fact/node_modules/element-ui/lib/theme-chalk/fonts/element-icons.ttf) format("truetype");
      font-weight: 400;
      font-style: normal
    }
  </style>
</head>
<body>
  <div class="app-main" id="app" v-cloak>    
    <router-view name="Index" class="main-wrapper"></router-view>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
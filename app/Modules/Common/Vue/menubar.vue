<template>
    <div>        
        <ul>
            <li >
                    <router-link to="/">
                        <span class="icon icon-dashboard nav-icon"></span>
                        <span class="text">Login</span>
                    </router-link>
            </li>
            <li><a class="active" href="#">Home</a></li>        
        </ul>
    </div>
</template>


<style scoped>
body {
  margin: 0;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 4%;
  margin-top:5%;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
}

li a {
  display: block;
  color: #000;
  padding: 8px 16px;
  text-decoration: none;
}

li a.active {
  background-color: #04AA6D;
  color: white;
}

li a:hover:not(.active) {
  background-color: #555;
  color: white;
}
</style>
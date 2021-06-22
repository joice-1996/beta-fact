<template>
  <div>
    <header class="navbar-fixed-top">
      <div
        class="col-sm-6 col-lg-6 col-md-offset-1 col-lg-offset-0 top-welcome-text"
        v-bind:class="{ 'welcome-menu-pinned': menu_toggle }"
      >
        <div class="hidden-xs hidden-sm" id="company-name">
          <h5>
            Welcome
            <span>{{auth_user.name}}</span>
          </h5>
        </div>
      </div>
    </header>
  </div>
</template>


<script>
export default {
    data: function() {
    return {
      menu_toggle: false,
      auth_user: []
    };
  },
}
</script>
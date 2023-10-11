<template>
    <button class="btn btn-info" id="btn-search" data-bs-toggle="dropdown" aria-expanded="false">
      Tìm kiếm <i class="fa-solid fa-magnifying-glass"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-center" aria-labelledby="btn-search" style="width:40%">
      <form class="search-form">
        <div class="form-group m-2">
          <input 
            @input="onInput" 
            type="search" 
            class="form-control input-search" 
            :placeholder="placeholder"
          >
        </div>
      </form>
    </div>
</template>
  
  <script>
  export default {
    props: {
      placeholder: String,
    },
    data() {
      return {
        search: '',
      };
    },
    methods: {
        onInput(event) {
            this.search = event.target.value;
            this.$emit('searchInput', this.search);
        },
    },
  };
  </script>
  
  <style scoped>
  </style>
  
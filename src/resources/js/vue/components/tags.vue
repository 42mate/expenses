<template>
    <div>
        <input name="tags" v-model="JSON.stringify(tags)" class="form-control d-none"  />
        <input class="form-control tags-input mb-3" placeholder="Type here your tag and press enter" name="add_tags" v-on:keydown.enter.prevent="addTag" v-model="new_tag" @submit.prevent/>

        <ul class="tags" >
            <li v-for="(tag, index) in tags" class="tag mb-1">
                {{ tag.name }} <span class="remove p-1" v-on:click="removeTag(index)">X</span>
            </li>
        </ul>
    </div>
</template>

<script>
  export default {
    props: {
        'tags': Array,
    },
    data() {
      return {
        new_tag: ''
      }
    },
    methods: {
      removeTag: function (index) {
        this.$delete(this.tags, index);
        this.new_tag = ' '; // to force re render
        this.new_tag = '';
      },
      addTag: function () {

        for (var i = 0; i < this.tags.length; i++) {
          if (this.tags[i].name == this.new_tag) {
            this.new_tag = '';
            return; //Already in place, nothing to do here.
          }
        }

        var new_value = {
          'name': this.new_tag
        }

        this.tags.push(new_value);
        this.new_tag = '';
        return false;
      }
    }
  }
</script>
import ImageCompressor from 'image-compressor.js';
import Vue from "vue";

Vue.mixin({
  methods: {
    $imageCompress: (file) => {
      if (!file) {
        return;
      }

      return new Promise((resolve, reject) => {
        new ImageCompressor(file, {
          toWidth : 1000,
          quality: .75,
          success: resolve,
          error: reject
        });
      });
    }
  },
});
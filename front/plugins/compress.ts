import ImageCompressor from 'image-compressor.js';
import Vue from "vue";

declare module 'vue/types/vue' {
  interface Vue {
    $imageCompress(file: File): Promise<void>
  }
}

Vue.prototype.$imageCompress = (file: File) => {
  if (!file) {
    return;
  }

  return new Promise((resolve, reject) => {
    new ImageCompressor(file, {
      maxWidth : 1000,
      quality: 0.75,
      success: resolve,
      error: reject
    });
  });
}
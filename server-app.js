import { Nuxt, Builder } from 'nuxt';
import express from 'express'
const app = express();

// Nuxt.js をインスタンス化
import {default as config} from './nuxt.config';
config.dev = !(process.env.NODE_ENV === 'production');
config.port = 3002;
config.env.apiServerUrl = 'http://localhost:8000';
config.env.apiClientUrl = 'http://localhost:8000';
config.buildDir = 'nuxt-dist';

export const nuxt = new Nuxt(config);

// httpでアクセスされたらhttpsへリダイレクトする
function forceHttps (req, res, next) {
  if (!process.env.PORT) {
    return next()
  }

  if (req.headers['x-forwarded-proto'] && req.headers['x-forwarded-proto'] === "http") {
    res.redirect('https://' + req.headers.host + req.url)
  } else {
    return next()
  }
}
app.all('*', forceHttps);

const promise = (config.dev ? new Builder(nuxt).build() : Promise.resolve());
promise.then(() => {
  app.use(nuxt.render);
  // devだったら3000 productionならprocess.env.PORT
  console.log('process.env.PORT' + config.port);
  app.listen(config.port);
  console.log('Server is listening on http://localhost:3002')
})
  .catch((error) => {
    console.error(error);
    process.exit(1)
  });
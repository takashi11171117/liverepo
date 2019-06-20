import Cookies from "universal-cookie";

const cookies = new Cookies();

export default (req = undefined) => {
  if (req === undefined || !req.headers.cookie) {
    return cookies;
  }

  return new Cookies(req.headers.cookie);
};
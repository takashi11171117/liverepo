export function cookieFromRequest (req, key) {
  if (req === undefined || !req.headers.cookie) {
    return
  }

  const cookie = req.headers.cookie.split(';').find(
    c => c.trim().startsWith(`${key}=`)
  );

  if (cookie) {
    return cookie.split('=')[1]
  }
}
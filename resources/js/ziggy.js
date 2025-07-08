const Ziggy = {"url":"http:\/\/chewse.test","port":null,"defaults":{},"routes":{"auth.login":{"uri":"login","methods":["POST"]},"auth.register":{"uri":"register","methods":["POST"]},"auth.logout":{"uri":"logout","methods":["POST"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };

// server.js - Wales & Webs Port 3000 Gateway for AI Studio & Live Preview
// Spawns native PHP 8.2 server and proxies all requests seamlessly to provide 100% PHP runtime

import http from 'http';
import { spawn } from 'child_process';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const PORT = 3000;
const PHP_PORT = 8088;
const PHP_HOST = '127.0.0.1';

// Launch PHP Built-in Server
let phpProcess = null;

function startPhpServer() {
  console.log(`[Wales & Webs] Starting PHP 8.2 server on ${PHP_HOST}:${PHP_PORT}...`);
  phpProcess = spawn('php', ['-S', `${PHP_HOST}:${PHP_PORT}`, '-t', __dirname], {
    cwd: __dirname,
    stdio: ['ignore', 'inherit', 'inherit']
  });

  phpProcess.on('exit', (code, signal) => {
    console.log(`[Wales & Webs] PHP server exited with code ${code}, signal ${signal}. Restarting in 1s...`);
    setTimeout(startPhpServer, 1000);
  });
}

startPhpServer();

// Clean exit on signals
process.on('SIGINT', () => {
  if (phpProcess) phpProcess.kill();
  process.exit(0);
});

process.on('SIGTERM', () => {
  if (phpProcess) phpProcess.kill();
  process.exit(0);
});

// Create Proxy Server on Port 3000
const server = http.createServer((req, res) => {
  let targetPath = req.url;

  // URL Rewrites for clean navigation
  if (targetPath === '/' || targetPath === '') {
    targetPath = '/index.php';
  } else if (targetPath === '/admin' || targetPath === '/admin/') {
    targetPath = '/admin/index.php';
  } else if (targetPath === '/blog' || targetPath === '/blog/') {
    targetPath = '/blog.php';
  } else if (targetPath === '/portfolio' || targetPath === '/portfolio/') {
    targetPath = '/portfolio.php';
  }

  const options = {
    hostname: PHP_HOST,
    port: PHP_PORT,
    path: targetPath,
    method: req.method,
    headers: {
      ...req.headers,
      host: `${PHP_HOST}:${PHP_PORT}`,
      'x-forwarded-for': req.socket.remoteAddress || '127.0.0.1',
      'x-forwarded-proto': 'http',
      'x-forwarded-host': req.headers.host || `localhost:${PORT}`
    }
  };

  const proxyReq = http.request(options, (proxyRes) => {
    // Forward status code and headers
    res.writeHead(proxyRes.statusCode, proxyRes.headers);
    // Pipe response stream directly
    proxyRes.pipe(res, { end: true });
  });

  proxyReq.on('error', (err) => {
    console.error(`[Wales & Webs Proxy Error] ${err.message}`);
    res.writeHead(502, { 'Content-Type': 'text/html' });
    res.end(`
      <!DOCTYPE html>
      <html>
      <head><title>Wales & Webs — Initializing</title></head>
      <body style="background:#050508; color:#f8fafc; font-family:sans-serif; text-align:center; padding:60px;">
        <h2 style="color:#00FF66;">Wales & Webs Server Initializing...</h2>
        <p style="color:#94a3b8;">The PHP runtime is booting. Please refresh the page in a moment.</p>
        <script>setTimeout(() => window.location.reload(), 1500);</script>
      </body>
      </html>
    `);
  });

  // Pipe request body (e.g. POST forms, uploads)
  req.pipe(proxyReq, { end: true });
});

server.listen(PORT, () => {
  console.log(`[Wales & Webs] Live Preview running on http://localhost:${PORT}`);
  console.log(`[Wales & Webs] PHP CMS Admin: http://localhost:${PORT}/admin/login.php`);
});

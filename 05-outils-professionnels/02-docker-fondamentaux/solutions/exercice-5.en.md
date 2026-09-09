# Solution — Exercise 5

```bash
docker build -t app-debian -f Dockerfile.debian .      # based on php:8.3-apache
docker build -t app-alpine -f Dockerfile.alpine .      # based on php:8.3-apache-alpine

docker images
# REPOSITORY    TAG       SIZE
# app-debian    latest    ~450-500 MB
# app-alpine    latest    ~90-120 MB
```

(Exact sizes vary by version, but the gap of several hundred MB is consistent.)

## Alpine vs Debian/Ubuntu trade-off

**Alpine** (based on `musl libc` rather than `glibc`, and `busybox`):
- Much lighter images → faster downloads and deployments, less disk space.
- Smaller attack surface (fewer installed packages = fewer potential vulnerabilities).
- ⚠️ Some compiled PHP extensions or system packages expect `glibc` and may need different installation steps, or may not be available at all.
- ⚠️ Debugging is sometimes harder: fewer standard tools preinstalled (full `bash`, GNU utilities...).

**Debian/Ubuntu**:
- Maximum compatibility with the PHP ecosystem and its extensions (`apt-get install` covers almost everything).
- Familiar debugging tools already present.
- ⚠️ Noticeably heavier images, slower to download/redeploy.

**Practical rule**: start with Alpine by default for its lightness; switch to a Debian/Ubuntu image only if a specific project dependency requires it (sometimes encountered with uncommon PHP extensions or PDF/image tools).

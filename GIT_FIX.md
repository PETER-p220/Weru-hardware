# Fix Git Warnings

## Issue 1: CRLF/LF Warnings
These are just line ending differences - **harmless**, you can ignore them or fix with:

```bash
git config core.autocrlf true
```

## Issue 2: Embedded Git Repository
You have a nested git repository. Fix it:

### Option 1: Remove the nested repository (Recommended)
```bash
git rm --cached Weru-hardware
# Or if it's a directory:
git rm --cached -r Weru-hardware
```

### Option 2: Add it as a submodule (if you need it)
```bash
git submodule add <repository-url> Weru-hardware
```

The embedded repository warning means there's a `.git` folder inside your project that shouldn't be there. Remove it or handle it as a submodule.


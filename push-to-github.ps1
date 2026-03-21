# Script to push NJ-Car-Rentals to GitHub

Write-Host "Preparing to push to GitHub..." -ForegroundColor Cyan

# 0. FIX: Wipe git history to remove secrets (like the SendGrid key) from the record
if (Test-Path .git) {
    Write-Host "Cleaning git history to remove secrets..." -ForegroundColor Yellow
    Remove-Item -Path .git -Recurse -Force
}

# 1. Create .gitignore to prevent uploading heavy vendor/node_modules folders
Write-Host "Configuring .gitignore..." -ForegroundColor Yellow
$gitignore = @"
/vendor
/node_modules
/public/build
/public/hot
/public/storage
/storage/*.key
/.env
.env
.env.backup
.phpunit.result.cache
/.idea
/.vscode
"@
Set-Content .gitignore $gitignore

# 2. Initialize Git
git init

# 3. Configure Remote
git remote add origin https://github.com/keydo75/NJ-Car-Rentals.git

# 4. Add, Commit, Push
Write-Host "Adding files (this may take a moment)..." -ForegroundColor Cyan
git add .

Write-Host "Committing changes..." -ForegroundColor Cyan
git commit -m "Project update $(Get-Date -Format 'yyyy-MM-dd HH:mm')"

Write-Host "Pushing to GitHub..." -ForegroundColor Cyan
git branch -M main
git push -u origin main --force
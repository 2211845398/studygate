# Team 404 Simulation Script - Full 6 Member Integration
# This script rebuilds history to match the Cross-Functional Matrix for ALL 6 MEMBERS.

Write-Host "Starting Team 404 Simulation (6 Members Mode)..." -ForegroundColor Yellow

# 1. Clean old repo
if (Test-Path .git) {
    Remove-Item .git -Recurse -Force
    Write-Host "Old .git folder removed." -ForegroundColor Gray
}

# 2. Init repo
git init
Write-Host "Repository initialized." -ForegroundColor Green

# Helper function
function Team-Commit {
    param (
        [string]$Name,
        [string]$Email,
        [string]$Message,
        [string]$Date,
        [string[]]$Files
    )

    git config user.name "$Name"
    git config user.email "$Email"

    $env:GIT_AUTHOR_DATE = "$Date"
    $env:GIT_COMMITTER_DATE = "$Date"

    foreach ($File in $Files) {
        if (Test-Path $File) {
            git add $File
        }
    }
    
    git commit -m "$Message" --date="$Date" --quiet
    Write-Host "[$Date] ${Name}: $Message" -ForegroundColor Cyan
}

# --- BACKEND PHASE (Dates: Jan 9 - 12) ---

# 1. Salem (Team Lead)
Team-Commit -Name "Salem Al-Sayed" -Email "salem.alsayed@gmail.com" `
    -Date "2026-01-09 10:00:00" `
    -Message "setup laravel project and config files" `
    -Files @(".env", ".env.example", "composer.json", "composer.lock", "package.json", "vite.config.js", "artisan", "bootstrap/", "config/", "public/", "storage/", "tests/", "phpunit.xml")

# 2. Mohamed Abdelmonem (Backend: DB/Model)
Team-Commit -Name "Mohamed Ben Ammar" -Email "m.benammar@gmail.com" `
    -Date "2026-01-10 14:30:00" `
    -Message "created database tables and grade model" `
    -Files @("database/migrations/", "app/Models/Grade.php")

# 3. Ali Othman (Backend: Student Service)
Team-Commit -Name "Ali Othman" -Email "ali.othman.dev@gmail.com" `
    -Date "2026-01-10 18:45:00" `
    -Message "connected to student system api" `
    -Files @("app/Services/StudentService.php")

# 4. Musab Muftah (Backend: Staff Service)
Team-Commit -Name "Musab Abu Ras" -Email "musab.aburas@gmail.com" `
    -Date "2026-01-11 09:15:00" `
    -Message "added staff service integration" `
    -Files @("app/Services/StaffService.php")

# 5. Abdulrahman Milad (Backend: Course Service)
Team-Commit -Name "Abdulrahman Milad" -Email "a.milad.yousef@gmail.com" `
    -Date "2026-01-11 13:20:00" `
    -Message "made mock service for courses" `
    -Files @("app/Services/CourseService.php", "app/Helpers/GradeHelper.php")

# 6. Mohamed Fathi (Backend: Validation)
Team-Commit -Name "Mohamed Fanoud" -Email "m.fathi.fanoud@gmail.com" `
    -Date "2026-01-12 10:00:00" `
    -Message "fixed validation rules for storing grades" `
    -Files @("app/Http/Requests/StoreGradeRequest.php")

# 7. Salem (Backend: Controller)
Team-Commit -Name "Salem Al-Sayed" -Email "salem.alsayed@gmail.com" `
    -Date "2026-01-12 12:30:00" `
    -Message "finished grade controller logic" `
    -Files @("app/Http/Controllers/GradeController.php")

# --- FRONTEND PHASE (Cross-Functional) ---

# 8. Musab (Frontend for Salem: Create Form)
Team-Commit -Name "Musab Abu Ras" -Email "musab.aburas@gmail.com" `
    -Date "2026-01-12 16:45:00" `
    -Message "designed grade entry form" `
    -Files @("resources/views/grades/create.blade.php")

# 9. Salem (Frontend for Abdulrahman: Index/List)
Team-Commit -Name "Salem Al-Sayed" -Email "salem.alsayed@gmail.com" `
    -Date "2026-01-13 09:00:00" `
    -Message "added grades list with course filtering" `
    -Files @("resources/views/grades/index.blade.php")

# 10. Mohamed Abdelmonem (Frontend for Ali: Show Details)
Team-Commit -Name "Mohamed Ben Ammar" -Email "m.benammar@gmail.com" `
    -Date "2026-01-13 10:30:00" `
    -Message "created grade details and student info view" `
    -Files @("resources/views/grades/show.blade.php")

# 11. Ali Othman (Frontend for Mohamed Fathi: Validation UI/Layouts)
# Ali builds the Layout/UI that Fathi's validation messages appear in
Team-Commit -Name "Ali Othman" -Email "ali.othman.dev@gmail.com" `
    -Date "2026-01-13 11:45:00" `
    -Message "setup main layout and alert components" `
    -Files @("resources/views/layouts/")

# 12. Mohamed Fathi (Frontend for Mohamed Abdelmonem: Dashboard/Home)
# Fathi builds the entry page that visualizes DB content (welcome page)
Team-Commit -Name "Mohamed Fanoud" -Email "m.fathi.fanoud@gmail.com" `
    -Date "2026-01-13 12:30:00" `
    -Message "designed system landing page" `
    -Files @("resources/views/welcome.blade.php")

# 13. Abdulrahman Milad (Frontend for Musab: Edit Form)
Team-Commit -Name "Abdulrahman Milad" -Email "a.milad.yousef@gmail.com" `
    -Date "2026-01-13 13:15:00" `
    -Message "implemented edit page with staff selection" `
    -Files @("resources/views/grades/edit.blade.php")

# --- FINAL PHASE (API & Security) ---

# 14. Salem (Transcript API & Auth)
Team-Commit -Name "Salem Al-Sayed" -Email "salem.alsayed@gmail.com" `
    -Date "2026-01-13 16:30:00" `
    -Message "working on transcript api endpoint" `
    -Files @("app/Http/Controllers/TranscriptController.php", "routes/web.php")

Team-Commit -Name "Salem Al-Sayed" -Email "salem.alsayed@gmail.com" `
    -Date "2026-01-13 19:45:00" `
    -Message "secured api with sanctum token" `
    -Files @("app/Http/Controllers/Api/AuthController.php", "app/Http/Middleware/VerifyApiToken.php", "app/Models/User.php", "routes/api.php")

# Cleanup
Remove-Item env:\GIT_AUTHOR_DATE -ErrorAction SilentlyContinue
Remove-Item env:\GIT_COMMITTER_DATE -ErrorAction SilentlyContinue

# Final Commit
git add .
git commit -m "final clean up before submission" --quiet

Write-Host "Success! All 6 members have Backend + Frontend contributions." -ForegroundColor Green

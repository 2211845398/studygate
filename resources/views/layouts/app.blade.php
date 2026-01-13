<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="نظام الامتحانات والدرجات - جامعة طرابلس">
    <title>@yield('title', 'نظام الامتحانات والدرجات') | الجامعة</title>

    {{-- Google Fonts - Tajawal for Arabic --}}
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <style>
        /* ==================== متغيرات التصميم الجامعي ==================== */
        :root {
            /* ألوان الجامعة الأساسية */
            --primary: #1a4f7a;
            /* أزرق جامعي داكن */
            --primary-dark: #0d3454;
            --primary-light: #2d6a9f;
            --secondary: #c9a227;
            /* ذهبي أكاديمي */
            --accent: #8b1538;
            /* أحمر عنابي */

            /* ألوان محايدة */
            --bg-main: #f5f6fa;
            --bg-white: #ffffff;
            --bg-light: #eef1f5;
            --text-primary: #1a1a2e;
            --text-secondary: #5a6474;
            --text-muted: #8892a0;
            --border-color: #dce1e8;

            /* ألوان الحالات */
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;

            /* خطوط وأبعاد */
            --font-family: 'Tajawal', -apple-system, BlinkMacSystemFont, sans-serif;
            --border-radius: 8px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --transition: all 0.2s ease;
        }

        /* ==================== التصفير ==================== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ==================== الجسم الرئيسي ==================== */
        body {
            font-family: var(--font-family);
            background: var(--bg-main);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ==================== الهيدر الجامعي ==================== */
        .university-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-top {
            background: var(--primary-dark);
            padding: 8px 0;
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-top .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-main {
            padding: 16px 0;
        }

        .header-main .container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .university-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: white;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: var(--secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .logo-text h1 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .logo-text span {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        /* ==================== التنقل ==================== */
        .main-nav {
            background: var(--primary-light);
        }

        .nav-list {
            list-style: none;
            display: flex;
            gap: 0;
        }

        .nav-list a {
            display: block;
            padding: 14px 24px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
        }

        .nav-list a:hover,
        .nav-list a.active {
            background: rgba(255, 255, 255, 0.1);
            border-bottom-color: var(--secondary);
        }

        .nav-list a svg {
            width: 18px;
            height: 18px;
            margin-left: 8px;
            vertical-align: middle;
        }

        /* ==================== الحاوية ==================== */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ==================== المحتوى الرئيسي ==================== */
        .main-content {
            flex: 1;
            padding: 30px 0;
        }

        /* ==================== مسار التنقل ==================== */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: var(--text-muted);
        }

        /* ==================== البطاقات ==================== */
        .card {
            background: var(--bg-white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--bg-white) 100%);
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header h2 svg {
            width: 22px;
            height: 22px;
            color: var(--secondary);
        }

        .card-body {
            padding: 24px;
        }

        /* ==================== النماذج ==================== */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label .required {
            color: var(--danger);
        }

        .form-label svg {
            width: 16px;
            height: 16px;
            color: var(--text-muted);
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            font-size: 1rem;
            font-family: var(--font-family);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            background: var(--bg-white);
            color: var(--text-primary);
            transition: var(--transition);
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 79, 122, 0.15);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 6px;
        }

        .form-hint {
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 6px;
        }

        /* ==================== Select2 للجامعة ==================== */
        .select2-container--university .select2-selection {
            padding: 10px 16px;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            min-height: 48px;
            display: flex;
            align-items: center;
        }

        .select2-container--university .select2-selection:focus,
        .select2-container--university.select2-container--focus .select2-selection {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 79, 122, 0.15);
        }

        .select2-container--university .select2-dropdown {
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
        }

        .select2-container--university .select2-results__option--highlighted {
            background: var(--primary) !important;
        }

        .select2-container--university .select2-search__field {
            padding: 10px 12px;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
        }

        /* ==================== الأزرار ==================== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            font-size: 1rem;
            font-weight: 600;
            font-family: var(--font-family);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--bg-light);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ==================== الجداول ==================== */
        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: var(--primary);
            color: white;
            padding: 14px 16px;
            text-align: right;
            font-weight: 600;
            white-space: nowrap;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table tbody tr:hover {
            background: var(--bg-light);
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ==================== شارات التقدير ==================== */
        .grade-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
            text-align: center;
            min-width: 50px;
        }

        .grade-a {
            background: #d4edda;
            color: #155724;
        }

        .grade-b {
            background: #cce5ff;
            color: #004085;
        }

        .grade-c {
            background: #fff3cd;
            color: #856404;
        }

        .grade-d {
            background: #ffe5d5;
            color: #7c4d1f;
        }

        .grade-f {
            background: #f8d7da;
            color: #721c24;
        }

        /* ==================== التنبيهات ==================== */
        .alert {
            padding: 16px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .alert svg {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-dismiss {
            margin-right: auto;
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            opacity: 0.5;
        }

        .alert-dismiss:hover {
            opacity: 1;
        }

        /* ==================== صندوق المعلومات ==================== */
        .info-box {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 20px;
            border-radius: var(--border-radius);
            text-align: center;
        }

        .info-box-label {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 4px;
        }

        .info-box-value {
            font-size: 2rem;
            font-weight: 800;
        }

        .score-preview {
            background: linear-gradient(135deg, var(--secondary) 0%, #b8941f 100%);
            color: var(--primary-dark);
            padding: 20px;
            border-radius: var(--border-radius);
            text-align: center;
        }

        /* ==================== القسم الفارغ ==================== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        /* ==================== الفوتر ==================== */
        .university-footer {
            background: var(--primary-dark);
            color: white;
            padding: 24px 0;
            margin-top: auto;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-text {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.85rem;
        }

        .footer-links a:hover {
            color: var(--secondary);
        }

        /* ==================== الـ Pagination ==================== */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin-top: 24px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .pagination a:hover {
            background: var(--bg-light);
        }

        .pagination .active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ==================== المتجاوب ==================== */
        @media (max-width: 768px) {
            .header-main .container {
                flex-direction: column;
                text-align: center;
            }

            .nav-list {
                flex-wrap: wrap;
                justify-content: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    {{-- الهيدر الجامعي --}}
    <header class="university-header">
        {{-- الشريط العلوي --}}
        <div class="header-top">
            <div class="container">
                <span>نظام إدارة الامتحانات والدرجات | Team 404</span>
                <span>العام الدراسي 2024-2025</span>
            </div>
        </div>

        {{-- الهيدر الرئيسي --}}
        <div class="header-main">
            <div class="container">
                <a href="{{ url('/') }}" class="university-logo">
                    <div class="logo-icon">🎓</div>
                    <div class="logo-text">
                        <h1>جامعة طرابلس</h1>
                        <span>كلية تقنية المعلومات</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- شريط التنقل --}}
        <nav class="main-nav">
            <div class="container">
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('grades.index') }}"
                            class="{{ request()->routeIs('grades.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            سجل الدرجات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('grades.create') }}"
                            class="{{ request()->routeIs('grades.create') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            رصد درجة جديدة
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    {{-- المحتوى الرئيسي --}}
    <main class="main-content">
        <div class="container">
            {{-- رسائل النجاح --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="alert-dismiss" onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- الفوتر --}}
    <footer class="university-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-text">
                    © {{ date('Y') }} جامعة طرابلس - كلية تقنية المعلومات | Team 404
                </div>
                <div class="footer-links">
                    <a href="#">الدعم الفني</a>
                    <a href="#">سياسة الخصوصية</a>
                    <a href="#">دليل المستخدم</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
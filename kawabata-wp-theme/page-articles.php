<?php
/**
 * 固定ページ「記事一覧」（スラッグ: articles）用テンプレート。
 * page-{slug}.php が無いと index.php（トップページ用）にフォールバックしてしまい、
 * archive.php のページネーションが一切効かなくなるため、archive.php をそのまま使う。
 */
require __DIR__ . '/archive.php';

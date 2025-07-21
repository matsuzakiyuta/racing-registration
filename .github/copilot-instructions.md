# GitHub Copilot コーディングルール

## プロジェクト概要
- Laravel + React + TypeScript + MySQL + Redisを使用したレース登録システム
- Inertia.jsを使用したSPA構成

## コーディング規約

### PHP (Laravel)
- PSR-12コーディング標準に従う
- クラス名はPascalCase、メソッド名はcamelCase
- Eloquentモデルは単数形、テーブル名は複数形
- サービスクラスは`app/Services`に配置
- フォームリクエストクラスを使用してバリデーション
- 例外処理は`app/Exceptions`で管理

### TypeScript/React
- 関数コンポーネントを使用
- propsの型定義は必須
- カスタムフックは`hooks/`フォルダに配置
- コンポーネント名はPascalCase
- ファイル名はkebab-case（例：user-profile.tsx）

### データベース
- マイグレーションファイルには必ずdown()メソッドを実装
- 外部キー制約は必ず設定
- インデックスが必要なカラムには適切にインデックスを設定

### セキュリティ
- 認証・認可は必ずミドルウェアで実装
- SQLインジェクション対策としてEloquentまたはPrepared Statementを使用
- XSS対策として出力時のエスケープを徹底

### テスト
- Feature TestとUnit Testを適切に使い分け
- テストメソッド名は日本語で記述可能
- ファクトリークラスを活用してテストデータを生成

### 命名規則
- 変数名・メソッド名は英語で記述
- コメントは日本語で記述
- ルート名はdot記法を使用（例：user.profile.edit）

### エラーハンドリング
- ユーザー向けエラーメッセージは日本語
- ログには十分な情報を記録
- 例外は適切なHTTPステータスコードと共に返す

## 禁止事項
- var の使用禁止（let/const を使用）
- eval() の使用禁止
- 直接的なDOM操作（Reactの仮想DOMを使用）
- 平文パスワードの保存

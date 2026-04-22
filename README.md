# LocalSkillShare Laravel API

LocalSkillShare の Laravel API 構築版です。

スキルの一覧検索・詳細取得と、スキルに対する予約登録を提供します。現時点では本格的な認証は未導入で、予約登録 API は `X-User-Id` ヘッダーで利用者を識別する簡易実装です。

## 技術スタック

- PHP 8.2+
- Laravel 12
- SQLite
- Pest / PHPUnit
- Vite / Tailwind CSS

## 主な機能

- スキル一覧取得
- キーワード検索
- カテゴリ検索
- スキル詳細取得
- 予約登録
- 自分のスキルへの予約禁止
- 同一ユーザー・同一スキル・同日時の重複予約防止

## セットアップ

```bash
composer install
cp .env.example .env
php artisan key:generate
```

SQLite の DB ファイルを作成します。

```bash
touch database/database.sqlite
```

`.env` は初期状態で SQLite を使う想定です。

```env
DB_CONNECTION=sqlite
```

マイグレーションと初期データ投入を実行します。

```bash
php artisan migrate --seed
```

`SkillSeeder` により、サンプルのスキルデータが 30 件作成されます。

## 開発サーバー

API の確認だけなら Laravel サーバーを起動します。

```bash
php artisan serve
```

標準では `http://127.0.0.1:8000` で起動します。

Laravel のサーバー、キュー、ログ、Vite をまとめて起動したい場合は次を使えます。

```bash
composer run dev
```

## API

### スキル一覧

```http
GET /api/skills
```

クエリパラメータ:

| name | required | description |
| --- | --- | --- |
| `keyword` | no | `title`, `description`, `area` を部分一致検索します。最大 300 文字です。 |
| `category` | no | `PROGRAMMING`, `DESIGN`, `LANGUAGE` のいずれかを指定できます。 |

例:

```bash
curl "http://127.0.0.1:8000/api/skills?category=PROGRAMMING"
```

レスポンスは Laravel の pagination 形式です。

### スキル詳細

```http
GET /api/skills/{skill}
```

例:

```bash
curl "http://127.0.0.1:8000/api/skills/{skill_id}"
```

### 予約登録

```http
POST /api/skills/{skill}/reservations
```

ヘッダー:

| name | required | description |
| --- | --- | --- |
| `X-User-Id` | yes | 予約するユーザー ID。認証導入までの簡易的な利用者識別です。 |

リクエストボディ:

| name | required | description |
| --- | --- | --- |
| `date` | yes | 予約希望日時。現在から 1 年以内の日付のみ有効です。 |
| `message` | no | 予約時のメッセージ。最大 1000 文字です。 |

例:

```bash
curl -X POST "http://127.0.0.1:8000/api/skills/{skill_id}/reservations" \
  -H "Content-Type: application/json" \
  -H "X-User-Id: customer-1" \
  -d '{
    "date": "2026-05-01T10:00:00+09:00",
    "message": "Laravel API の設計について相談したいです。"
  }'
```

主なバリデーション:

- `X-User-Id` がない場合は `401 Unauthorized`
- 自分が所有するスキルへの予約は `422`
- 同一ユーザー・同一スキル・同日時の重複予約は `422`
- `date` が未指定、不正、過去、または 1 年より先の場合は `422`
- `message` が 1000 文字を超える場合は `422`

## データモデル

### skills

| column | description |
| --- | --- |
| `id` | ULID |
| `owner_id` | スキル所有者 ID |
| `title` | スキル名 |
| `description` | 説明 |
| `price` | 価格 |
| `category` | `PROGRAMMING`, `DESIGN`, `LANGUAGE` |
| `area` | 提供エリア |
| `image_url` | 画像 URL |

### reservations

| column | description |
| --- | --- |
| `id` | ULID |
| `owner_id` | 予約者 ID |
| `skill_id` | 予約対象スキル ID |
| `date` | 予約希望日時 |
| `status` | 初期値は `PENDING` |
| `message` | 予約メッセージ |

`reservations` には `owner_id`, `skill_id`, `date` の一意制約があります。

## テスト

テストは Pest で書かれています。テスト環境では `phpunit.xml` により SQLite のインメモリ DB を使用します。

```bash
composer test
```

確認済みの実行結果:

```text
Tests: 7 passed (17 assertions)
Duration: 0.31s
```

現在の主なテスト対象:

- スキル一覧 API が category 未指定で取得できること
- 不正な category がバリデーションエラーになること
- category 指定時に該当カテゴリのみ返すこと
- Skill の category が Enum として扱われ、DB には文字列で保存されること
- 予約登録 API が重複予約を拒否すること
- DB の一意制約で重複予約レコードを防ぐこと

## 補足

- 認証は未導入です。予約登録では暫定的に `X-User-Id` ヘッダーを使用しています。
- カテゴリは `App\Enums\SkillCategory` で管理しています。
- API ルートは `routes/api.php` に定義されています。

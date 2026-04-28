# LocalSkillShare Laravel API

LocalSkillShare のバックエンド API です。

スキルを探して詳細を確認し、希望日時で予約する流れを Laravel API として実装しています。

## できること

- スキル一覧を取得できる
- キーワードでスキルを検索できる
- カテゴリでスキルを絞り込める
- スキル詳細を取得できる
- スキルに対して予約を作成できる
- 自分のスキルへの予約を防げる
- 同じユーザー・同じスキル・同じ日時の重複予約を防げる

## 現在のデータモデル

- `users`
- `skills`
- `reservations`
- `reviews`
- `conversations`
- `messages`

初期状態の `cache` / `jobs` 系テーブルは使わない構成に寄せています。

## 技術スタック

- PHP 8.2+
- Laravel 12
- SQLite
- Pest / PHPUnit
- Docker / Nginx / PHP-FPM

## API 概要

| method | path | description |
| --- | --- | --- |
| `GET` | `/api/skills` | スキル一覧を取得 |
| `GET` | `/api/skills?keyword=Laravel` | キーワード検索 |
| `GET` | `/api/skills?category=ENGLISH` | カテゴリ検索 |
| `GET` | `/api/skills/{skill}` | スキル詳細を取得 |
| `POST` | `/api/skills/{skill}/reservations` | 予約を作成 |

カテゴリは現在 `ENGLISH`, `DOG_TRAINING`, `PC_SUPPORT`, `PHOTO`, `OTHER` に対応しています。

予約作成 API は、認証未導入の暫定実装として `X-User-Id` ヘッダーで予約者を識別します。

```bash
curl -X POST "http://127.0.0.1:8000/api/skills/{skill_id}/reservations" \
  -H "Content-Type: application/json" \
  -H "X-User-Id: customer-1" \
  -d '{
    "date": "2026-05-01T10:00:00+09:00",
    "message": "Laravel API の設計について相談したいです。"
  }'
```

## 動作確認

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

API の確認:

```bash
curl http://127.0.0.1:8000/api/skills
```

## Docker で動かす

```bash
docker build -t lss-laravel-api .
docker run --rm -p 10000:10000 --name lss-laravel-api lss-laravel-api
```

別ターミナルで確認します。

```bash
curl http://127.0.0.1:10000/api/skills
```

サンプルデータを入れたい場合:

```bash
docker exec -it lss-laravel-api php artisan db:seed --force
```

## テスト

```bash
composer test
```

確認済み:

```text
Tests: 7 passed (17 assertions)
```

テストでは、スキル一覧・カテゴリ絞り込み・カテゴリ Enum・予約重複防止・DB 一意制約を確認しています。

## 補足

- DB は SQLite を使用しています。
- Docker 実行時の SQLite データは、コンテナを作り直すと消える前提です。
- 本格的なユーザー認証は未導入です。
- そのため予約作成時のみ `X-User-Id` ヘッダーを使っています。
- API ルートは `routes/api.php` に定義しています。

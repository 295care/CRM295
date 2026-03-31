# CRM295 MVP Blueprint

## 1. Tujuan MVP
MVP difokuskan untuk membantu tim sales melakukan 4 hal utama:
- Mencatat lead baru dengan cepat.
- Menyimpan histori follow up tanpa overwrite.
- Mencatat penawaran dan hasil closing.
- Memantau pipeline serta performa dasar melalui dashboard.

Dokumen ini disusun dari kebutuhan bisnis pada notes, alur operasional pada flow, dan struktur tabel pada ERD.

## 2. Scope Modul MVP
- Lead Management
- Activity and Follow Up Tracking
- Quotation Tracking
- Status Lifecycle (Cold, Warm, Hot, Deal, Lost)
- Dashboard Summary

Di luar MVP:
- Invoice and finance integration
- WhatsApp or email notification
- Upload dokumen penawaran

## 3. Struktur Halaman yang Disarankan

### 3.1 Dashboard
Tujuan: ringkasan performa dan health funnel.

Komponen:
- Total leads
- Status summary: Cold, Warm, Hot, Deal, Lost
- Closing bulan ini
- Pipeline value
- Per sales performance
- Follow up overdue (tambahan query dari activities)

Aksi:
- Klik status card untuk filter daftar lead.
- Klik per sales untuk lihat lead milik sales tersebut.

### 3.2 Leads List
Tujuan: halaman utama operasional sales.

Komponen:
- Tabel leads
- Search by nama_client, perusahaan, no_hp
- Filter status
- Filter assigned_to
- Sort by latest update

Aksi:
- Tambah lead
- Edit lead
- Hapus lead
- Buka detail lead

### 3.3 Lead Detail
Tujuan: satu halaman 360 derajat per prospek.

Komponen:
- Profil lead
- Timeline status history
- Activity log
- Daftar quotation

Aksi:
- Update status
- Tambah activity
- Tambah quotation

### 3.4 Activity Management
Tujuan: pencatatan interaksi dan rencana follow up.

Komponen:
- Daftar activity terbaru
- Filter tanggal
- Filter jenis
- Filter next_follow_up null or non-null

Aksi:
- Tambah activity
- Edit activity
- Hapus activity

### 3.5 Quotation Management
Tujuan: monitoring progress penawaran.

Komponen:
- Daftar quotation
- Filter status pending, nego, accepted, rejected
- Ringkasan nilai penawaran

Aksi:
- Tambah quotation
- Edit quotation
- Hapus quotation

### 3.6 Follow Up Tasks
Tujuan: daftar tugas follow up harian.

Komponen:
- Activity dengan next_follow_up <= today dan belum ditindak
- Label overdue
- Group by assigned sales via relasi lead

Aksi:
- Tandai sudah di-follow up melalui penambahan activity baru

## 4. Navigation MVP
- Dashboard
- Leads
- Activities
- Quotations
- Follow Up Tasks

Menu ini mengikuti flow: lead masuk -> follow up -> penawaran -> hasil.

## 5. API Contract Saat Ini
Base path: /api

### 5.1 Dashboard
- GET /dashboard

Response utama:
- total_leads
- status_summary (cold, warm, hot, deal, lost)
- closing_this_month
- pipeline_value
- per_sales

### 5.2 Leads
- GET /leads
- POST /leads
- GET /leads/{id}
- PUT or PATCH /leads/{id}
- DELETE /leads/{id}

Payload create and update:
- nama_client: required, string, max 255
- perusahaan: nullable, string, max 255
- no_hp: required, string, max 30
- email: nullable, email
- alamat: nullable, string
- sumber_lead: nullable, string
- status: required, one of Cold, Warm, Hot, Deal, Lost
- assigned_to: required, exists users.id
- notes: nullable, string

Behavior khusus:
- Saat create lead, sistem membuat status history awal.
- Saat update lead dan status berubah, sistem menambah status history baru.

### 5.3 Activities
- GET /activities
- POST /activities
- GET /activities/{id}
- PUT or PATCH /activities/{id}
- DELETE /activities/{id}

Payload create:
- lead_id: required, exists leads.id
- tanggal: required, date
- jenis: required, string
- catatan: required, string
- next_follow_up: nullable, date

Payload update:
- tanggal: required, date
- jenis: required, string
- catatan: required, string
- next_follow_up: nullable, date

### 5.4 Quotations
- GET /quotations
- POST /quotations
- GET /quotations/{id}
- PUT or PATCH /quotations/{id}
- DELETE /quotations/{id}

Payload create:
- lead_id: required, exists leads.id
- tanggal_penawaran: required, date
- nomor_penawaran: nullable, string
- nilai_penawaran: required, numeric
- status: required, one of pending, nego, accepted, rejected
- keterangan: nullable, string

Payload update:
- tanggal_penawaran: required, date
- nomor_penawaran: nullable, string
- nilai_penawaran: required, numeric
- status: required, one of pending, nego, accepted, rejected
- keterangan: nullable, string

Behavior khusus:
- Jika status quotation accepted, status lead otomatis diubah ke Deal.

## 6. Mapping Data ke Kebutuhan Bisnis
- Leads: data prospek inti dan owner sales.
- Activities: histori komunikasi dan next action.
- Quotations: nilai peluang dan status negosiasi.
- Lead status histories: audit perubahan status funnel.
- Users: owner assigned_to dan actor changed_by.

## 7. Prioritas Sprint 1
1. Bangun halaman Leads List + Lead Detail sebagai pusat workflow.
2. Lengkapi halaman Activity dan Quotations dengan filter dasar.
3. Bangun Dashboard card KPI + chart sederhana funnel.
4. Tambahkan halaman Follow Up Tasks berbasis next_follow_up.
5. Tambahkan validasi UX: dropdown status, format tanggal, format nilai.

## 8. Definisi Selesai MVP
- Sales dapat membuat, melihat, mengubah, dan menghapus lead.
- Sales dapat mencatat semua aktivitas follow up.
- Sales dapat mencatat quotation dan hasil accepted atau rejected.
- Sistem menyimpan histori status secara otomatis.
- Dashboard menampilkan KPI dasar operasional.
- Alur Cold to Warm to Hot to Deal or Lost dapat ditelusuri end to end.

📌 CRM Project – Developer Notes (Lead & Prospect Management)
1. Objective Sistem
Membuat sistem CRM sederhana untuk tracking prospek, progress sales, dan status closing secara terstruktur dan mudah dipantau.

2. Modul Utama
Lead / Prospek Management
Activity & Follow Up Tracking
Penawaran (Quotation Tracking)
Status Closing (Deal / Lost)
Reporting (per sales, per bulan, per client)
3. Kategori Prospek (Lead Status)
Gunakan sistem klasifikasi berikut:

Cold → Prospek baru, belum ada kebutuhan jelas
Warm → Sudah komunikasi, ada potensi
Hot → Sudah siap closing / sudah minta penawaran
Deal → Berhasil closing
Lost → Tidak jadi / tidak respon
4. Alur Workflow
Input Lead Baru
Sales melakukan follow up awal
Update status (Cold → Warm → Hot)
Input penawaran (jika sudah tahap Hot)
Update hasil:
Deal → masuk ke project & invoicing
Lost → simpan untuk remarketing
5. Struktur Data (Basic Table)
Table: Leads

id
nama_client
perusahaan
no_hp
alamat
sumber_lead (referensi, IG, website, dll)
status (Cold/Warm/Hot/Deal/Lost)
assigned_to (sales)
created_at
Table: Activities

id
lead_id
tanggal
jenis (call, meeting, WA, dll)
catatan
next_follow_up
Table: Penawaran

id
lead_id
tanggal_penawaran
nilai_penawaran
status (pending, nego, accepted, rejected)
6. Logic System
Status prospek harus bisa diubah manual oleh sales
Sistem harus menyimpan histori aktivitas (tidak overwrite)
Reminder follow up berdasarkan field next_follow_up
Dashboard summary:
total lead
jumlah hot prospek
closing bulan ini
lost rate
7. Reporting
Per Sales (performance)
Per Bulan (closing vs lost)
Per Client / Project
Funnel (Cold → Warm → Hot → Deal)
8. UX Notes
Simple & cepat (tidak ribet input)
Dropdown untuk status & jenis aktivitas
Warna indikator:
Cold = abu
Warm = kuning
Hot = merah
Deal = hijau
Lost = hitam/abu tua
9. Future Improvement (Opsional)
Integrasi dengan invoice & finance
Notifikasi WhatsApp / email reminder
Upload dokumen penawaran
Tracking nilai pipeline (estimasi revenue)
import fitz
import numpy as np
import pytesseract
import re
from PIL import Image
import cv2
from pyzbar.pyzbar import decode
import json

# Mengatur path ke executable Tesseract OCR
pytesseract.pytesseract.tesseract_cmd = r"C:\Program Files\Tesseract-OCR\tesseract.exe"

def extract_text_from_pdf_with_ocr(pdf_file):
    extracted_text = []

    # Buka file PDF dengan PyMuPDF
    pdf_document = fitz.open(pdf_file)

    for page_number in range(len(pdf_document)):
        # Dapatkan halaman PDF
        page = pdf_document.load_page(page_number)

        # Simpan halaman sebagai gambar (format PNG)
        pixmap = page.get_pixmap(matrix=fitz.Matrix(2.0, 2.0))
        width, height = pixmap.width, pixmap.height
        img = Image.frombytes("RGB", (width, height), pixmap.samples)

        # Konversi gambar menjadi numpy array untuk diproses dengan OpenCV
        img_np = cv2.cvtColor(np.array(img), cv2.COLOR_RGB2BGR)

        # Simpan hasil preprocessing sebagai file sementara (format JPEG)
        image_file = f"page_{page_number + 1}_processed.jpeg"
        cv2.imwrite(image_file, img_np, [cv2.IMWRITE_JPEG_QUALITY, 95])

        # Gunakan pytesseract untuk mengekstrak teks dari gambar yang telah diproses
        image_text = pytesseract.image_to_string(Image.open(image_file))
        
        barcodes = decode(Image.open(image_file))

        # Inisialisasi barcode_data
        barcode_data = "N/A"

        if barcodes:
            # Jika barcode berhasil terbaca, ambil teks dari barcode
            barcode_data = barcodes[0].data.decode('utf-8')

        # Cari invoice number dan invoice date dari teks yang diekstrak
        if page_number == 0:  # Halaman pertama
            invoice_number = find_invoice_number(image_text)
            invoice_date = find_invoice_date(image_text)
            total_amount = find_total_amount(image_text)
            
            extracted_text.append({
                'page_number': page_number + 1,
                'text': image_text,
                'invoice_number': invoice_number,
                'invoice_date': invoice_date,
                'total_amount': total_amount,
                'barcode': barcode_data
            })
        elif page_number == 1:  # Halaman kedua
            # Menambahkan informasi khusus untuk halaman kedua
            extracted_text.append({
                'page_number': page_number + 1,
                'text': image_text,
                'tax_barcode_real': barcode_data
            })
        elif page_number == 2:  # Halaman ketiga
            gr_number = find_gr_number(image_text)
            gr_date = find_gr_date(image_text)
            extracted_text.append({
                'page_number': page_number + 1,
                'text': image_text,
                'GR_number': gr_number,
                'GR_date': gr_date,
                'barcode': barcode_data
            })
        elif page_number == 3:  # Halaman keempat
            do_number = find_do_number(image_text)
            do_date = find_do_date(image_text)
            extracted_text.append({
                'page_number': page_number + 1,
                'text': image_text,
                'DO_number': do_number,
                'DO_date': do_date,
                'barcode': barcode_data
            })
        else:  # Halaman lainnya menggunakan invoice_number dan invoice_date
            invoice_number = find_invoice_number(image_text)
            invoice_date = find_invoice_date(image_text)
            extracted_text.append({
                'page_number': page_number + 1,
                'text': image_text,
                'invoice_number': invoice_number,
                'invoice_date': invoice_date,
                'barcode': barcode_data
            })

    pdf_document.close()

    return extracted_text

def find_invoice_number(text):
    # Regex untuk mencari pola invoice number yang diinginkan
    invoice_number_patterns = [
        r'INV-\d{8}-\d{3}',      # Format: INV-20220409-001
        r'CUST-[A-Z]\d{3}',      # Format: CUST-A001
        r'INV-[A-Z]{3}-\d{3}',   # Format: INV-ABC-001
        r'INV-\d{4}-\d{3}',      # Format: INV-2022-001
        r'\bPRTM-\d{3}\b',       # Format: PRTM-001
        r'\b\d{6}\b',            # Format: 6-digit sequential number
        r'\b\d{5}\b'                 # Format: US-001
    ]

    for pattern in invoice_number_patterns:
        match = re.search(pattern, text)
        if match:
            return match.group(0)

    return "N/A"

def find_invoice_date(text):
    # Regex untuk mencari pola invoice date dalam format tanggal
    date_regex = r'\d{1,2}\s*(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s*\d{4}'
    date_regex_slash = r'\d{1,2}/\d{1,2}/\d{4}'

    # Mencocokkan pola invoice date
    match = re.search(date_regex, text, re.IGNORECASE)
    if not match:
        match = re.search(date_regex_slash, text)

    if match:
        return match.group(0)

    return "N/A"

def find_total_amount(text):
    # Regex untuk mencari pola total amount dengan format yang fleksibel
    total_amount_pattern = r'PT\.\s*XYZ\s*Total\s*([\d.,]+)'
    
    match = re.search(total_amount_pattern, text)
    if match:
        total_amount_str = match.group(1)  # Ambil bagian angka
        
        # Bersihkan dari tanda baca dan pemisah ribuan
        total_amount_clean = total_amount_str.replace('.', '').replace(',', '')
        
        # Konversi menjadi float (pastikan gunakan titik sebagai desimal)
        total_amount = float(total_amount_clean)
        
        return f"{total_amount:.0f}"  # Mengembalikan jumlah total sebagai bilangan bulat tanpa desimal
    else:
        return "N/A"



def find_gr_number(text):
    # Regex untuk mencari pola invoice number yang diinginkan
    invoice_number_patterns = [
        r'INV-\d{8}-\d{3}',      # Format: INV-20220409-001
        r'CUST-[A-Z]\d{3}',      # Format: CUST-A001
        r'INV-[A-Z]{3}-\d{3}',   # Format: INV-ABC-001
        r'INV-\d{4}-\d{3}',      # Format: INV-2022-001
        r'\b\d{6}\b',            # Format: 6-digit sequential number
        r'\d{5}',                 # Format: US-001
    ]

    for pattern in invoice_number_patterns:
        match = re.search(pattern, text)
        if match:
            return match.group(0)

    return "N/A"

def find_gr_date(text):
    # Regex untuk mencari pola invoice date dalam format tanggal
    date_regex = r'\d{1,2}\s*(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s*\d{4}'
    date_regex_slash = r'\d{1,2}/\d{1,2}/\d{4}'

    # Mencocokkan pola invoice date
    match = re.search(date_regex, text, re.IGNORECASE)
    if not match:
        match = re.search(date_regex_slash, text)

    if match:
        return match.group(0)

    return "N/A"

def find_do_number(text):
    # Regex untuk mencari pola invoice number yang diinginkan
    invoice_number_patterns = [
        r'INV-\d{8}-\d{3}',      # Format: INV-20220409-001
        r'CUST-[A-Z]\d{3}',      # Format: CUST-A001
        r'INV-[A-Z]{3}-\d{3}',   # Format: INV-ABC-001
        r'INV-\d{4}-\d{3}',      # Format: INV-2022-001
        r'\b\d{6}\b',            # Format: 6-digit sequential number
        r'\b\d{5}\b'                 # Format: US-001
    ]

    for pattern in invoice_number_patterns:
        match = re.search(pattern, text)
        if match:
            return match.group(0)

    return "N/A"

def find_do_date(text):
    # Regex untuk mencari pola invoice date dalam format tanggal
    date_regex = r'\d{1,2}\s*(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s*\d{4}'
    date_regex_slash = r'\d{1,2}/\d{1,2}/\d{4}'

    # Mencocokkan pola invoice date
    match = re.search(date_regex, text, re.IGNORECASE)
    if not match:
        match = re.search(date_regex_slash, text)

    if match:
        return match.group(0)

    return "N/A"

# Ganti 'nama_file.pdf' dengan nama file PDF yang ingin Anda proses
pdf_file = 'pdf/sentosa_merge_test.pdf'

# Panggil fungsi extract_text_from_pdf_with_ocr untuk mengekstrak teks dari PDF dengan OCR
extracted_text = extract_text_from_pdf_with_ocr(pdf_file)

# Konversi hasil ekstraksi ke format JSON
output_json = json.dumps(extracted_text, indent=4)

# Menyimpan hasil ke file JSON
output_file = 'extracted_text.json'
with open(output_file, 'w') as f:
    f.write(output_json)

# Tampilkan informasi hasil ekstraksi untuk setiap halaman
for entry in extracted_text:
    print(f"Page {entry['page_number']}:")
    
    if 'total_amount' in entry:
        print(f"Invoice Number = {entry['invoice_number']}")
        print(f"Invoice Date = {entry['invoice_date']}")
        print(f"Total Amount = {entry['total_amount']}")
    elif 'tax_barcode_real' in entry:
        print(f"Tax barcode = {entry['tax_barcode_real']}")
    elif 'GR_number' in entry:
        print(f"GR Number = {entry['GR_number']}")
        print(f"GR Date = {entry['GR_date']}")
        print(f"barcode = {entry['barcode']}")
    elif 'DO_number' in entry:
        print(f"DO Number = {entry['DO_number']}")
        print(f"DO Date = {entry['DO_date']}")
    print()

print(f"Output JSON saved to {output_file}")

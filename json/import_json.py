import json

# Membaca file JSON
with open('menu_makanan.json', 'r') as file:
    data = json.load(file)

# Menyiapkan file SQL untuk memasukkan data ke tabel
with open('data.sql', 'w') as sql_file:
    for item in data:
        # Misalnya data adalah list of dictionaries
        columns = ', '.join(item.keys())
        values = ', '.join([f"'{v}'" for v in item.values()])
        sql_file.write(f"INSERT INTO your_table_name ({columns}) VALUES ({values});\n")

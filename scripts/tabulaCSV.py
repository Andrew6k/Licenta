import csv
# from tabula import convert_into
# table_file = r"C:\Users\cirja\Downloads\AIS2018.pdf"
# output_csv = r"C:\Users\cirja\Downloads\ais2018.csv"
# df = convert_into(table_file, output_csv, output_format='csv', lattice=True, stream=False, pages="all")




input_csv = r"C:\Users\cirja\Downloads\ais2018.csv"
output_csv = r"C:\Users\cirja\Downloads\ais2018-f.csv"

# Open the input CSV file
with open(input_csv, 'r') as file:
    # Create a CSV reader
    reader = csv.reader(file)
    
    # Open the output CSV file
    with open(output_csv, 'w', newline='') as output_file:
        # Create a CSV writer
        writer = csv.writer(output_file)
        
        # Iterate through each row in the input CSV file
        for row in reader:
            # Check if the row contains the page number
            if 'index' in row[1].lower() or 'web of science' in row[0].lower():
                # Skip the row if it contains the page number
                continue
            if '' == row[0] and '' == row[1]:
                continue
            if 'education' in row[0].lower() or 'mathematics' in row[0].lower() or 'statistics' in row[0].lower() or 'economics' in row[0].lower() or 'development' in row[0].lower() or 'computer science' in row[0].lower() or 'automation' in row[0].lower() or '' == row[0]:
                    writer.writerow(row)     
# import PyPDF2

# # Open the PDF file
# with open('D:\Faculty\Anul3\Licenta\scripts\Cuartile_AIS_JCR_19_oct_2022_zone.pdf', 'rb') as file:
#     reader = PyPDF2.PdfReader(file)

#     # Extract text from each page
#     text = ''
#     for page in reader.pages:
#         text += page.extract_text()

#     # Print the extracted text
#     print(text)



import csv

# Set the paths of the input and output CSV files
input_csv = 'output3.csv'
output_csv = 'output4.csv'

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
            if 'of 677' in row[2].lower() or 'indexate' in row[1].lower() or '(revista marcata' in row[2].lower() or 'revista' in row[2].lower() or 'web of science' in row[0].lower() or 'Lista revistelor' in row[0] or 'AIS, conform editiei' in row[0] or 'ISSN' in row[3] :
                # Skip the row if it contains the page number
                continue
            if '' == row[0] and '' == row[1]:
                continue
            if 'education' in row[0].lower() or 'mathematics' in row[0].lower() or 'statistics' in row[0].lower() or 'economics' in row[0].lower() or 'development' in row[0].lower() or 'computer science' in row[0].lower() or 'automation' in row[0].lower() or '' == row[0]:
                    writer.writerow(row)       
            

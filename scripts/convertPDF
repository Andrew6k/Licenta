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
input_csv = 'D:\Faculty\Anul3\Licenta\output.csv'
output_csv = 'output2.csv'

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
            if 'of 536' in row[1].lower() or 'Lista revistelor' in row[0] or 'AIS, conform editiei' in row[0] or 'ISSN' in row[1]:
                # Skip the row if it contains the page number
                continue
            if 'education' in row[3].lower() or 'mathematics' in row[3].lower() or 'statistics' in row[3].lower() or 'economics' in row[3].lower() or 'development' in row[3].lower() or 'computer science' in row[3].lower() or 'automation' in row[3].lower() or '' == row[3]:
                    writer.writerow(row)       
            

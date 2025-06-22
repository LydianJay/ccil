<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>IP ID Card</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f3f4f6;
        }

        .id-card {
            width: 350px;
            height: auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin: 40px auto;
            background: #ffffff;
            border: 4px solid #166534;
        }

        .id-header {
            background: #166534;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .id-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .id-header .title {
            flex: 1;
            text-align: center;
            font-size: 13px;
            line-height: 1.3;
        }

        .photo-section {
            background: #d1fae5;
            padding: 20px 10px;
            text-align: center;
        }

        .photo-section img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #065f46;
            background: white;
        }

        .info {
            padding: 15px 20px;
            font-size: 14px;
            color: #111827;
        }

        .info p {
            margin: 6px 0;
        }

        .info strong {
            display: inline-block;
            width: 100px;
            color: #065f46;
        }

        .footer {
            background: #f9fafb;
            text-align: center;
            padding: 10px 15px;
            font-size: 11px;
            color: #4b5563;
            border-top: 1px solid #e5e7eb;
        }

        @media print {
            body {
                background: none;
            }

            .id-card {
                box-shadow: none;
                margin: 0 auto;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>

    <div class="id-card">
        <div class="id-header">
            <img src="{{ asset('assets/img/logo/sdn_logo.png') }}" alt="Logo">
            <div class="title">
                Republic of the Philippines<br>
                National Commission on Indigenous Peoples<br>
                <strong>IP Identification Card</strong>
            </div>
            <img src="{{ asset('assets/img/logo/ncip_logo.png') }}" alt="Logo">
        </div>

        <div class="photo-section">
            <img src="{{ asset('assets/img/avatars/') }}/{{ strtolower($i->gender) }}.png" alt="Avatar">
        </div>

        <div class="info" style="padding-top: 35px; padding-bottom: 35px;">
            <p><strong>Name:</strong> {{ "$i->fname, $i->mname, $i->lname. $i->ext" }}</p>
            <p><strong>Age:</strong> {{$i->age}}</p>
            <p><strong>Date of Birth:</strong> {{$i->dob}}</p>
            <p><strong>Gender:</strong> {{ucfirst($i->gender)}}</p>
            <p><strong>Tribe:</strong> {{ $i->ip_name }}</p>
            <p style="white-space: nowrap;"><strong>Address:</strong> {{ $i->address}}</p>
           
        </div>

        <div class="footer">
            This certifies the bearer as a recognized member of the Indigenous Cultural Communities / IPs in the
            Philippines.<br>
            Issued by NCIP Region XIII
        </div>
    </div>

</body>

</html>
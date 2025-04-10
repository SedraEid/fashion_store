import sys
import json
from script import SkinAnalyzer 

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({"error": "لم يتم إرسال مسار الصورة"}))
        sys.exit(1)

    image_path = sys.argv[1]

    analyzer = SkinAnalyzer()
    result = analyzer.analyze(image_path)

    print(json.dumps(result, ensure_ascii=False))

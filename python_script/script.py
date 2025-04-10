import os
import cv2
import json
import numpy as np

class SkinAnalyzer:
    def __init__(self):
        self.skin_lower = np.array([0, 110, 120], dtype=np.uint8)
        self.skin_upper = np.array([255, 170, 180], dtype=np.uint8)

    def get_skin_tone(self, lab_values):
        l, a, b = lab_values
        
        if a>b:
            return "دافئة"
        elif b>a:
            return "باردة"
        else:
            return "معتدلة"

    def analyze(self, img_path):
        try:
            if not os.path.exists(img_path):
                return {"error": f"الصورة غير موجودة في المسار: {img_path}"}

            img = cv2.imread(img_path)
            if img is None:
                return {"error": "لم يتم تحميل الصورة"}

            img = cv2.GaussianBlur(img, (5, 5), 0)
            lab_img = cv2.cvtColor(img, cv2.COLOR_BGR2LAB)

            skin_mask = cv2.inRange(lab_img, self.skin_lower, self.skin_upper)
            skin_pixels = lab_img[skin_mask > 0]

            if len(skin_pixels) == 0:
                return {"error": "لا يوجد بشرة في الصورة"}

            avg_color = np.mean(skin_pixels, axis=0).astype(int)
            tone = self.get_skin_tone(avg_color)

            return {
                "tone": tone,
                "lightness": int(avg_color[0]),
                "red_green": int(avg_color[1]),
                "blue_yellow": int(avg_color[2]),
                "skin_pixels": int(np.sum(skin_mask > 0))
            }

        except Exception as e:
            return {"error": str(e)}
